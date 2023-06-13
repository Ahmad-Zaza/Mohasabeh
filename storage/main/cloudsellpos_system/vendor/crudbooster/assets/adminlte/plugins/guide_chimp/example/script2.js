var tour = [
    {
        element: '#massege-info',
        title: 'رسالة تنبيه',
        description: 'أقرأ رسالة التنبيه بدقة ستساعدك بفهم ألية عمل النظام',
    },
    {
        element: '#btn_add_new_data',
        title: 'إضافة حساب جديد',
        description: 'يمكنك إضافة حساب جديد من هنا. حيث تقوم بملأ البطاقة واختيار الحساب الأب الذي سيندرج تحته الحساب الجديد',
    },
    {
        element: '.button_action',
        title: 'أزرار إدارة العناصر',
        description: 'يمكنك استخدام  هذه الأزرار لإدارة العناصر من مشاهدة أو تعديل أو حذف',
    },
    {
        element: '.indicator',
        title: 'مشاهدة الأبناء',
        description: 'لمشاهدة أبناء حساب معين يمكنك استخدام هذه الزر',
    }
];

//GuideChimp.extend(guideChimpPluginLicensing, { id: "guidechimp-demo@labs64.com" });
//GuideChimp.extend(guideChimpPluginTriggers);
var guideChimp = GuideChimp(tour, {
        /**
         * By default, the Enter (13) key moves GuideChimp to the next step,
         * but we need a trigger event on the input, so we overridden the keys "useKeyboards.next"
         */
        useKeyboard: {
            next: [39, 32],
        }
    });

    guideChimp.on('onBeforeChange', (to, from) => {
        if (from && from.condition && !from.condition()) {
            return false;
        }
    });

document.getElementById('StartTour').onclick = function () {
    guideChimp.start();
};
