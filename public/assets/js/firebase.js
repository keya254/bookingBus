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

    getphonenumber(phone_number)
    {
        const phoneNumber = '+2'+phone_number+'';
        const appVerifier = window.recaptchaVerifier;
        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
          .then((confirmationResult) => {
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
          const user = result.user;
          // ...
        }).catch((error) => {
          // User couldn't sign in (bad verification code?)
          // ...
        });
    }
   
}