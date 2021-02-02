import React, { Fragment } from 'react';
import './App.css';
import {
  HashRouter as Router,
  Route
} from "react-router-dom";
import Login from './screens/Login/login'
import Home from './screens/home/home'
import Anuncios from './screens/anuncios/anuncios'
import InicioTurista from './screens/Turista/inicioTurista'

function App() {

  return (
    <Router>
      <Route exact path="/" component={Login}></Route>
      <Route exact path="/Home" component={Home}></Route>
      <Route exact path="/Anuncios" component={Anuncios}></Route>
      <Route exact path="/Viajes" component={Anuncios}></Route>
      <Route exact path="/Propuestas" component={Anuncios}></Route>
      <Route exact path="/InicioT" component={InicioTurista}></Route>
    </Router>    
  );
}

export default App;