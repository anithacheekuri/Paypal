<body>
<script src="https://www.paypal.com/sdk/js?client-id=AeEnHOmXys9LpmXWh7NFwoJKR5ZwSg5IadLuECUGMSd4BEM1W-5UNYJcTEwsF7KzIjw1uJsXatgKZ-2g"></script>

<div id="paypal-button-container"></div>


<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '0.01'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
        // This function shows a transaction success message to your buyer.
        alert('Transaction completed by ' + details.payer.name.given_name);
      });
    }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>
</body>