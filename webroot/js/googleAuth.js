var firebaseConfig = {
    apiKey: "AIzaSyBirrCTRG0izuupcogYXgo_PT8EzKzm2SU",
    authDomain: "nathan-mizzi-sss-home.firebaseapp.com",
    projectId: "nathan-mizzi-sss-home",
    storageBucket: "nathan-mizzi-sss-home.appspot.com",
    messagingSenderId: "1000859819206",
    appId: "1:1000859819206:web:c9da924d1d223a6d73cbc7",
    measurementId: "G-XC3ZHHDZCY"
};

var nameFromGoogle = "";
var emailFromGoogle = "";
var passwordFromGoogle = "";

firebase.initializeApp(firebaseConfig);

function googlePopup(_callback){

    if (!firebase.auth().currentUser) {

    var provider = new firebase.auth.GoogleAuthProvider();
    provider.addScope('https://www.googleapis.com/auth/contacts.readonly');

    firebase.auth().signInWithPopup(provider).then(function(result) {

        var user = result.user;

        console.log(user);

        nameFromGoogle = user.displayName;
        emailFromGoogle = user.email;
        passwordFromGoogle = user.providerData[0].uid;

        _callback();

    }).catch(function(error) {
        console.error(error);
    });
    }

}
