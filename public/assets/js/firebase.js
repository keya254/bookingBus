class MyFirebase
{
    firebaseConfig = {
      apiKey: "AIzaSyDago6Qit9CGTk4ABoGZXDSzL_WLGAIae8",
      authDomain: "booking-car-c5c45.firebaseapp.com",
      projectId: "booking-car-c5c45",
      storageBucket: "booking-car-c5c45.appspot.com",
      messagingSenderId: "517228364225",
      appId: "1:517228364225:web:469db6abaaf06e9363ef40",
      measurementId: "G-C3NZ4C0R6L"
    };

    initialize()
    {
        if (firebase.apps.length) {
            var  myNewConfig=this.firebaseConfig;
            firebase.app().delete().then(function() {
             firebase.initializeApp(myNewConfig);
            });
        }
         if (!firebase.apps.length) {
              firebase.initializeApp(this.firebaseConfig);
         }
          firebase.app();
          firebase.auth().languageCode = 'ar';
    }

    refreshrecaptch()
    {
         window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            'size': 'invisible',
            'callback': (response) => {
              // reCAPTCHA solved, allow signInWithPhoneNumber.
              onSignInSubmit();
         }
         });
    }

    getphonenumber(phone_number,formcode)
    {
        const phoneNumber = '+2'+phone_number+'';
        const appVerifier = window.recaptchaVerifier;
        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
          .then((confirmationResult) => {
            $('#trip-'+localStorage.getItem('trip')).html(formcode);
            // SMS sent. Prompt user to type the code from the message, then sign the
            // user in with confirmationResult.confirm(code).
            window.confirmationResult = confirmationResult;
            // ...
          }).catch((error) => {
            // Error; SMS not sent
            // ...
          });
    }

    verifycode(usercode)
    {
        const code = usercode;
        confirmationResult.confirm(code).then((result) => {
          // User signed in successfully.
          this.senddata();
         // alert('success');
          const user = result.user;
          // ...
        }).catch((error) => {
            alert('not');
          // User couldn't sign in (bad verification code?)
          // ...
        });
    }

    senddata()
    {
        var trip_id = localStorage.getItem('trip');
        var name = localStorage.getItem('name');
        var phone_number = localStorage.getItem('phone_number');
        var myseats = localStorage.getItem('seats_'+trip_id);
      $.ajax({
          type: "post",
          url: "/booking",
          data: {trip_id:trip_id,myseats:myseats,name:name,phone_number:phone_number},
          dataType: "json",
          success: function (response) {
             localStorage.clear();
             console.log(response.message);
          },
          error: function(response) {
            var err = eval("(" + response.responseText + ")");
            console.log(err.message);
          }
      });
    }



}
