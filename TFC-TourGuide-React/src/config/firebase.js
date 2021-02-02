import firebase from 'firebase'

var firebaseConfig = {
    apiKey: "AIzaSyAE66pDqs6M9e2oUzh_CEhB6UKSIdgqvjo",
    authDomain: "tourguide-71430.firebaseapp.com",
    databaseURL: "https://tourguide-71430.firebaseio.com",
    projectId: "tourguide-71430",
    storageBucket: "tourguide-71430.appspot.com",
    messagingSenderId: "287506159692",
    appId: "1:287506159692:web:86d1c09ff9e77b6784bce9",
    measurementId: "G-3NLRYJ1YQF"
  };

const fire = firebase.initializeApp(firebaseConfig);
  
export default fire;