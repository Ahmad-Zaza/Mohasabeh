<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GenerateSiteStatusReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generate {customer_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customer_id = $this->argument('customer_id');
        if ($customer_id == null) {
            $customers = DB::table('customers')->get();
            foreach ($customers as $customer) {
                $customerDB = "{$customer->database_name}";
                $customerDBHost = "localhost";
                $customerDBUser = "{$customer->database_name}";
                $customerDBPassword = "{$customer->database_password}";
                try {
                    $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
                } catch (PDOException $ex) {
                    continue;
                }
                try {
                    $bills_count = $this->getCount($dbh, 'bills');
                    $vouchers_count = $this->getCount($dbh, 'vouchers');
                    $package_config_data = $this->getPackageConfigData($dbh);
                    $clients_count = $this->getCount($dbh, 'persons');
                    $users_count = $this->getCountWithJoin($dbh);
                    $inventories_count = $this->getCount($dbh, 'inventories');
                    $currencies_count = $this->getCount($dbh, 'currencies');
                    $attachment_size = $this->calculateAttachmentSize($customer->folder_location);
                    $subscription_type = $this->determineSubscriptionType($package_config_data);
                    $subscription_dates = $this->getSubscriptionDates($package_config_data);
                    $site_status = $this->prepareSiteStatusData($customer->id, $bills_count, $vouchers_count, $package_config_data, $clients_count, $users_count, $inventories_count, $currencies_count, $attachment_size, $subscription_type, $subscription_dates);

                    DB::table('site_status')->updateOrInsert(
                        ['customer_id' => $customer->id],
                        $site_status
                    );
                } catch (Exception $ex) {
                    // Handle the exception as needed
                    report($ex);
                }
            }
        } else {
            $customer = DB::table('customers')->where('id', $customer_id)->first();
            $customerDB = "{$customer->database_name}";
            $customerDBHost = "localhost";
            $customerDBUser = "{$customer->database_name}";
            $customerDBPassword = "{$customer->database_password}";
            try {
                $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
            } catch (PDOException $ex) {
                report($ex);
            }
            try {
                $bills_count = $this->getCount($dbh, 'bills');
                $vouchers_count = $this->getCount($dbh, 'vouchers');
                $package_config_data = $this->getPackageConfigData($dbh);
                $clients_count = $this->getCount($dbh, 'persons');
                $users_count = $this->getCountWithJoin($dbh);
                $inventories_count = $this->getCount($dbh, 'inventories');
                $currencies_count = $this->getCount($dbh, 'currencies');
                $attachment_size = $this->calculateAttachmentSize($customer->folder_location);
                $subscription_type = $this->determineSubscriptionType($package_config_data);
                $subscription_dates = $this->getSubscriptionDates($package_config_data);
                $site_status = $this->prepareSiteStatusData($customer->id, $bills_count, $vouchers_count, $package_config_data, $clients_count, $users_count, $inventories_count, $currencies_count, $attachment_size, $subscription_type, $subscription_dates);
                DB::table('site_status')->updateOrInsert(
                    ['customer_id' => $customer->id],
                    $site_status
                );
            } catch (Exception $ex) {
                // Handle the exception as needed
                report($ex);
            }
        }
        return 0;
    }

    private function getCount($dbh, $table)
    {
        $query = "SELECT COUNT(*) FROM `$table`";
        $stmt = $dbh->query($query);
        return $stmt->fetchColumn();
    }

    private function getCountWithJoin($dbh)
    {
        $query = "SELECT count(*) FROM `cms_users`
                INNER JOIN `cms_privileges` ON cms_privileges.id = cms_users.id_cms_privileges
                WHERE cms_privileges.is_superadmin != 1";
        $stmt = $dbh->query($query);
        return $stmt->fetchColumn();
    }

    private function getPackageConfigData($dbh)
    {
        $query = "SELECT * FROM `package_config`";
        $stmt = $dbh->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    private function calculateAttachmentSize($folderLocation)
    {
        $attachment_size = 0;
        $storagePath = $folderLocation . '/site/storage/app';
        if (file_exists($storagePath)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePath)) as $file) {
                $attachment_size += $file->getSize();
            }
            // calculate size in MB
            $attachment_size = round($attachment_size / 1024 / 1024, 2);
        }
        return $attachment_size;
    }

    private function determineSubscriptionType($package_config_data)
    {
        if ($package_config_data['free_trial_start_date'] == null || $package_config_data['free_trial_start_date'] == '0000-00-00') {
            return 'Year';
        }
        return 'Free Trial';
    }

    private function getSubscriptionDates($package_config_data)
    {
        $start_date = $package_config_data['free_trial_start_date'] ?? $package_config_data['subscription_start_date'];
        $end_date = $package_config_data['free_trial_end_date'] ?? $package_config_data['subscription_end_date'];

        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }

    private function prepareSiteStatusData($customer_id, $bills_count, $vouchers_count, $package_config_data, $clients_count, $users_count, $inventories_count, $currencies_count, $attachment_size, $subscription_type, $subscription_dates)
    {
        return [
            'customer_id' => $customer_id,
            'bills_count' => $bills_count,
            'vouchers_count' => $vouchers_count,
            'allowed_users_count' => $package_config_data['users_num'],
            'used_users_count' => $users_count,
            'allowed_inventories_count' => $package_config_data['inventories_num'],
            'used_inventories_count' => $inventories_count,
            'allowed_currencies_count' => $package_config_data['currencies_num'],
            'used_currencies_count' => $currencies_count,
            'allowed_clients_count' => $package_config_data['clients_num'],
            'used_clients_count' => $clients_count,
            'allowed_attachs_size' => $package_config_data['attachs_size'],
            'used_attachs_size' => $attachment_size,
            'subscription_start_date' => $subscription_dates['start_date'],
            'subscription_end_date' => $subscription_dates['end_date'],
            'subscription_type' => $subscription_type,
        ];
    }

}
