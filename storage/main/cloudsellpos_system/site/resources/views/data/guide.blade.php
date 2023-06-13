@extends('crudbooster::admin_template')
@section('content')
    @php
        $main_path = CRUDBooster::mainpath();
    @endphp
    <div class="callout callout-success">
        <h4>مرحبًا بك في دليل استخدام أداة استيراد البيانات </h4>
        أداة استيراد البيانات هي من ضمن أهم العمليات التي يوفرها النظام والتي يستفيد منها المستخدم
        وخاصةً عند بدأ استخدام النظام. حيث تكون قاعدة البيانات فارغة ويحتاج المستخدم لإدخال بياناته من زبائن و ومواد...
        والخ.
        <br>
        يمكن للمستخدم العمل على النظام وإدخال بياناته يدويا بالاعتماد على الخدمات التي يقدمها النظام من إضافة وتعديل وحذف
        لجميع الموديولات
        <br>
        ولكن في حال كان المستخدم يستخدم نظام محاسبة سابق ويملك بيانات سابقة وبكمية كبية
        <b>فاستخدام أداة استيراد البيانات هي الحل المثالي لتوفير الوقت والجهد</b>
        .

    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-text-width"></i>
            <h3 class="box-title"> البيانات القابلة للاستيراد</h3>
        </div>

        <div class="box-body">
            <dl>
                <dt>الزبائن</dt>
                <dd>يوفر النظام استيراد الزبائن مع المعلومات الخاصة بكل زبون ويضيفها للنظام ويولد حسابات خاصة بهم ويضيفهم
                    إلى شجرة الحسابات.</dd>
                <dt>تصنيفات المواد</dt>
                <dd>يوفر النظام استيراد شجرة تصنيفات المواد بتفاصيلها كافة</dd>
                <dd>ويقوم بهيكلتها بشكل هرمي بحيث يبين التصنيفات الرئيسية و التصنيفات الفرعية.</dd>
                <dt>المواد</dt>
                <dd> يوفر النظام إمكانية استيراد بيانات المواد بتفاصيلها كافة من اسم و سعر وكلفة و ... الخ.</dd>
                <dt>بضاعة أول مدة</dt>
                <dd>يوفر النظام إمكانية استيراد بضاعة أول مدة . حيث تكون جاهزة لعمل النظام </dd>
                <dt>السندات الإفتتاحية لحسابات الزبائن وحسابات الصناديق</dt>
                <dd> يوفر النظام إمكانية استيراد معلومات السندات الإفتتاحية لحسابات الزبائن وغيرها من الحسابات الموجودة ضمن
                    النظام.</dd>
                <dd> ليتم اعتمداها كقيم بدائية لرصيد الحسابات التي تسمح باستكمال عمل المستخدم بدون أي مشاكل.</dd>
            </dl>
            <p class="text-aqua">للتنويه : سيقوم النظام بتوفير ألية استيراد لعدد أكبر من البيانات للنظام والتقليل من إدخال
                البيانات يدوياً. وذلك ضمن الإصدارات الأخرى. </p>
        </div>

    </div>
    <div class="callout callout-info">
        <h4>سنقوم بعرض خطوات استيراد البيانات بالتفصيل لتوضيح آلية العمل </h4>
        <p> بعد حصولك على معلومات استخدام النظام من قبل الشركة. ستكون قاعدة البيانات فارغة. لاتحوي اي بيانات </p>
        <p>وبفرض أنك تملك نظام سابق وترود نقل بياناتك لنظامنا. سنعتمد عليك في بعض الخطوات لتقوم بإدخال معلومات معينة فكن
            جاهزاً.</p>
    </div>
    <ul class="timeline">

        <li class="time-label">
            <span class="bg-red">
                خطوات استيراد البيانات
            </span>
        </li>

        <li>
            <i class="fa  fa-money bg-red"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة الأولى</a> إدخال العملات</h3>
                <div class="timeline-body">
                    قم بإدخال العملات المراد التعامل بها ضمن نظامك . من خلال موديول العملات .
                    <br />
                    النظام يقوم بتوفير عملة رئيسية واحدة وهي الليرة السورية . إن أردت تغيير العملة الرئيسية فقم بإضافة عملة
                    أخرى وعتمدها كعملة رئيسية لنظامك.
                    <br />
                    النظام يقوم بتوليد حساب صندوق الخاص بالعملة المضافة ويضيفه إلى شجرة الحسابات تحت حسابات نقدية.
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-danger btn-xs" href='{{ url(config('crudbooster.ADMIN_PATH') . '/currencies') }}'
                        target="_blank">إدخال العملات</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-building-o bg-blue"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة الثانية</a> إدخال بيانات المستودعات</h3>
                <div class="timeline-body">
                    قم بإدخال بيانات مستودعاتك . باستخدام موديول إدارة المستودعات التي يوفر عمليات الإضافة والتعديل والحذف.
                    .
                    للتنويه عند اضافة المستودع هناك حقل اسمه المندوب اتركه فارغة . سنقوم بربط المستودع مع المندوب الخاص به
                    لاحقا بالخطوات التالية.
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs" href='{{ url(config('crudbooster.ADMIN_PATH') . '/inventories') }}'
                        target="_blank">إدخال المستودعات</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-user-plus bg-aqua"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة الثالثة</a> إدخال بيانات المندوبين</h3>
                <div class="timeline-body">
                    قم بإدخال معلومات المندوبين ضمن رابط إدارة المستخدمين . قم بإضافة معلومات المستخدم وإيميله وكلمة السر
                    الخاصة به وقم بتحديد دوره كمندوب مبيعات وبحقل المستودع قم باختيار المستودع المسؤول عنه المندوب.
                    <br>
                    سيقوم النظام بتوليد حساب صندوق باسم المندوب ويضاف لشجرة الحسابات تحت حسابات نقدية المندوبين. ويقوم
                    النظام بتوليد حساب زبائن المندوب ليتم إضافة الزبائن المتعلقة بالمندوب ضمنه
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-info btn-xs" href='{{ url(config('crudbooster.ADMIN_PATH') . '/users') }}'
                        target="_blank">إدخال المندوبين</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-users bg-green"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة الرابعة</a> استيراد الزبائن</h3>
                <div class="timeline-body">
                    قم باستخدام أداة استيراد البيانات ضمن صفحة الزبائن.
                    <br>
                    يرجى قراءة التفاصيل التي تقوم باستعراضها الآداة والتقيد بها بدقة لتلافي أي مجال للخطأ
                    حيث تقوم الآداة بتزويدك بنموزج لملأه لاستخدامه بعملية الاستيراد ومن اهم المعلومات التي يجب إدخالها بشكل
                    صحيح
                    هو رمز حساب صندوق المندوب والتي يمكنك أن تحصل عليه من خلال تنزيل شجرة الحسابات.
                    <br>
                    الغاية من رمز حساب صندوق المندوب هو معرفة الزبون لأي مندوب يتبع. فيرجى التقيد بإدخاله بشكل صحيح لجميع
                    الزبائن لتفادي أي مشاكل.
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-success btn-xs" href='{{ url(config('crudbooster.ADMIN_PATH') . '/persons') }}'
                        target="_blank"> استيراد الزبائن</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-file-text-o bg-yellow"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة الخامسة</a> استيراد السندات الإفتتاحية</h3>
                <div class="timeline-body">
                    قم باستخدام أداة استيراد البيانات ضمن صفحة السندات الإفتتاحية.
                    <br>
                    يرجى قراءة التفاصيل التي تقوم باستعراضها الآداة والتقيد بها بدقة لتلافي أي مجال للخطأ
                    حيث تقوم الآداة بتزويدك بنموزج لملأه لاستخدامه بعملية الاستيراد ومن اهم المعلومات التي يجب إدخالها بشكل
                    صحيح
                    هو رمز حساب الزبون والتي يمكنك أن تحصل عليه من خلال تنزيل شجرة الحسابات. ورمز العملة وهو الذي اخترته عند
                    إضافة عملاتك.
                    وقيم الرصيد
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-warning btn-xs" href='{{ url(config('crudbooster.ADMIN_PATH') . '/initial_voucher') }}'
                        target="_blank"> استيراد السندات الإفتتاحية</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-sitemap bg-gray"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة السادسة</a> استيراد تصنيفات المواد</h3>
                <div class="timeline-body">
                    قم باستخدام أداة استيراد البيانات ضمن صفحة تصنيفات المواد.
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-default btn-xs bg-gray"
                        href='{{ url(config('crudbooster.ADMIN_PATH') . '/item_categories') }}' target="_blank"> استيراد
                        تصنيفات المواد</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-dropbox bg-red"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة السابعة</a> استيراد المواد</h3>
                <div class="timeline-body">
                    قم باستخدام أداة استيراد البيانات ضمن صفحة المواد.
                    <br>
                    قم بالتقيد بالنموزج وخاصةً بحقل رمز تصنيف المادة وقيم كلفة المادة وسعرها.
                    ويمكنك الحصول على رمز التصنيف من صحفة تصنيفات المواد
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-danger btn-xs" href='{{ url(config('crudbooster.ADMIN_PATH') . '/items') }}'
                        target="_blank"> استيراد المواد</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-th-large bg-blue"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">الخطوة الثامنة</a> استيراد بضاعة أول المدة</h3>
                <div class="timeline-body">
                    قم باستخدام أداة استيراد البيانات ضمن صفحة بضاعة أول المدة.
                    <br>
                    قم بالتقيد بالنموزج وخاصة بحقول رمز المادة والذي يمكنك الحصول عليه من معلومات المادة بصفحة المواد
                    ورمز المستودع والذي تحصل عليه من تنزيل ملف معلومات المستودعات التي تزودك به أداة الاستيراد.
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs" href='{{ url(config('crudbooster.ADMIN_PATH') . '/inventory_beginning') }}'
                        target="_blank"> استيراد بضاعة أول مدة</a>
                </div>
            </div>
        </li>

        <li>
            <i class="fa fa-check bg-green"></i>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">تهانينا</a> </h3>
                <div class="timeline-body">
                    <b>
                        بإتمامك الخطوات السابقة بالترتيب وبدقة تكون قد قمت باستيراد بياناتك وأصبح نظامك جاهز للعمل وبدون أي
                        مشاكل
                        <br>
                        شكرا جزيلا لهتمامك بآلية استراد البيانات، وفي حال يوجد لديكم أي استفسار يمكنكم التواصل معنا في أي وقت.
                    </b>
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-success btn-xs"
                        href='{{ url(config('crudbooster.ADMIN_PATH') . '/admin/statistics') }}'> الصفحة الرئيسية </a>
                </div>
            </div>
        </li>
    </ul>
@endsection
