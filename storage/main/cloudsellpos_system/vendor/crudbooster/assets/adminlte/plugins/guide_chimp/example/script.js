var tour = [
    {
        element: '#user-input',
        title: 'Try & Buy',
        description: 'Move to the next step is only possible if user input provided.',
        condition() {
                const input = document.querySelector('#user-input');

                if (!input.value) {
                    alert('User input is empty!');
                    return false;
                }

                return true;
            },
        triggers: {
                next: {
                    element: '#user-input',
                    event: 'change',
                    listener(e) {
                        if (e.target.value) {
                            alert('User input: "' + e.target.value + '"')
                            this.next();
                        }
                    },
                }
            }
    },
    {
        element: '#subscription',
        title: 'Subscription',
        description: 'Subscription licensing model allows user to enable product for a specific period of time, with the possibility of the subscription renewal.',
        buttons: [
            {
                title: 'See more',
                class: 'tour-button',
                onClick: function () {
                    alert("Step button click");
                }
            }
        ],
    },
    {
        element: '#pricing-table',
        title: 'Pricing Table',
        description: 'Price and package in minutes without having to re-code or re-engineer back-office systems.',
        buttons: [
            {
                title: 'See more',
                class: 'tour-button',
                onClick: function () {
                    alert("Step button click");
                }
            }
        ],
    },
    {
        element: '#multi-feature',
        title: 'Multi Feature',
        description: 'This licensing model allows enabling or disabling product features on the users needs and budget. It may be used to create an upgrade path from a “lite” version to “standard,” “pro,” “enterprise” etc. versions without modifying the software or uninstalling the existing version.',
        buttons: [
            {
                title: 'See more',
                class: 'tour-button',
                onClick: function () {
                    alert("Step button click");
                }
            }
        ],
    },
    {
        element: '#node-locked',
        title: 'Node-Locked',
        description: 'Software is licensed for use only on one or more named computer systems. Usually, CPU serial number verification is used to enforce this type of license.',
        buttons: [
            {
                title: 'See more',
                class: 'tour-button',
                onClick: function () {
                    alert("Step button click");
                }
            }
        ],
    },
    {
        element: '#pay-per-use',
        title: 'Pay-per-Use',
        description: 'Limits the quantity of the license uses, in addition to the license validity. License fees are based on the actual usage.',
        buttons: [
            {
                title: 'See more',
                class: 'tour-button',
                onClick: function () {
                    alert("Step button click");
                }
            }
        ],
    },
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

document.getElementById('startTour').onclick = function () {
    guideChimp.start();
};
