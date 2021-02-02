import React, {useState} from 'react';
import TvImput from './../../components/tvInput'
import './login.css'
import {Animated} from "react-animated-css";
import { Redirect } from 'react-router-dom';
import fire from './../../config/firebase'

export default function Login () {

    const [usuario, setusuario] = useState("");
    const [contrasena, setcontrasena] = useState("");
    const [Administrador, setAdministrador] = useState(false)
    const [user, setuser] = React.useState(null)
    const [Texto, setTexto] = useState('Iniciar sesion')
    
    function authListener(){
        fire.auth().onAuthStateChanged((user)=>{
        if(user){
            setuser(user)
        }else{
            setuser(null)
        }
        })
    }

    React.useEffect(() => {   
        authListener()     
        if(usuario==='admin'&& contrasena==='159753'){
            setAdministrador(true)
            setTexto('Iniciar como administrador')
        }
    },[usuario,contrasena])  

    function handleChangeUsuario(event){
        setusuario(event.target.value);
    };
    function handleChangePswd(event){
        setcontrasena(event.target.value);
    };

    function login(){
        console.log('entro')
        fire.auth().signInWithEmailAndPassword(usuario,contrasena).then((u)=>{
            console.log(u.name)
        }).catch((error)=>{
            console.log(error)
        })
     }

    return(
        <div id='contenedor'>
            <Animated animationIn="bounceInLeft" animationOut="fadeOut" isVisible={true}> 
                <div className='div-login'>
                    <head>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
                    </head>
                    <h1></h1>
                    <img id="logo" src={require('./../../assets/images/login-tlf.svg')} alt="imagen de login"></img>
                    <TvImput type="text" texto="Usuario" imagen={require("./../../assets/images/persona.png")} handle={handleChangeUsuario} />
                    <TvImput type="password" texto="Contraseña" imagen={require("./../../assets/images/pswd.png")} handle={handleChangePswd}/>
                    <button className="boton-login" id='login' onClick={login} >{Texto}</button>
                    {(Administrador)&& <Redirect to={{pathname: '/home',state: { correcto: true}}} />}
                    {(user!== null) && <Redirect to={{pathname: '/iniciot'}} /> }
                </div>
            </Animated>
        </div>
    )
}