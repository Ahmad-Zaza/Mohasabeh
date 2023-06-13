<script>
/******* from app service provider ******/
var tour = @json($tour);
console.log(tour);
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

    /*
    //autoplay tour
    let tour_autoplay = @json($tour_autoplay);
    if(tour_autoplay == true){
        guideChimp.start();
    }*/
    
</script>
