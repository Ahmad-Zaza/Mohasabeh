if (typeof (paypal) != 'undefined') {
     paypal
          .Buttons({
               style: {
                    shape: 'rect',
                    color: 'gold',
                    layout: 'vertical',
                    label: 'paypal',
                    height:55
               },
               // Sets up the transaction when a payment button is clicked
               createOrder: function (data, actions) {
                    return fetch(routes.createTransaction, {
                         headers: {
                              "Content-Type": "application/json",
                              "Accept": "application/json",
                              "X-Requested-With": "XMLHttpRequest",
                              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                         },
                         method: "POST",
                         // use the "body" param to optionally pass additional order information
                         // like product ids or amount
                    })
                         .then((response) => response.json())
                         .then(response => {
                              if (response.code != undefined && response.code == -1) {
                                   window.location.replace(routes.pricing);
                                   return;
                              }
                              return response.id;
                         });
               },
               // Finalize the transaction after payer approval
               onApprove: function (data, actions) {
                    let captureURL = routes.captureTransaction.replace('transactionID', data.orderID);
                    return fetch(captureURL, {
                         headers: {
                              "Content-Type": "application/json",
                              "Accept": "application/json",
                              "X-Requested-With": "XMLHttpRequest",
                              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                         },
                         method: "POST",
                    })
                         .then((response) => response.json())
                         .then((orderData) => {
                              actions.redirect(routes.successPayment);
                         });
               },
               enableFunding: 'paypal,venmo',
          })
          .render("#paypal-button-container");
} else {

}
