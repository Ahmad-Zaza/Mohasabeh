<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use PDO;
use PDOException;

class ProfileController extends Controller
{
    public function change_email(Request $request)
    {
        return $request->all();
    }

    public function change_password(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|min:8',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8'
        ]);

        $password = $request->current_password;
        $customer = Auth::user();
        $customerDB = "{$customer->database_name}";
        $customerDBHost = "localhost";
        $customerDBUser = "{$customer->database_name}";
        $customerDBPassword = "{$customer->database_password}";
        try {
            $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            $query = "select * from cms_users where email = '$customer->email'";
            $res = $dbh->query($query);
            $user = $res->fetchAll(PDO::FETCH_ASSOC)[0];


            if (Hash::check($password, $user['password'])) {

                $new_password = Hash::make($request->password);

                $query = "UPDATE `cms_users` SET `password` = '$new_password' WHERE `cms_users`.`email` = '$customer->email';";
                $dbh->exec($query);

                return Redirect::back()->with(['success' => 'dashboard.The password updated successfully']);
            } else {

                return Redirect::back()->with(['error' => 'dashboard.The current password is incorrect']);
            }
        } catch (PDOException $ex) {
            return Redirect::back()->with(['error' => 'dashboard.Unable to make the connection']);
        }
    }

    public function change_personal_info(Request $request)
    {
        $this->validate($request, [
            'address' => 'required|max:255|string',
            'phone' => 'required|numeric',
            'company' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'first_name' => 'required|max:255|string',
        ]);

        $data = $request->all();
        $customer = Customer::find(Auth::user()->id);
        $customer->update($data);
        return Redirect::back()->with(['success' => 'dashboard.The personal inforamtion updated successfully']);
    }
}
