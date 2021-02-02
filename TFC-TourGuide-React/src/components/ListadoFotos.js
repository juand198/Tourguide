import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import GridList from '@material-ui/core/GridList';
import GridListTile from '@material-ui/core/GridListTile';
import GridListTileBar from '@material-ui/core/GridListTileBar';
import IconButton from '@material-ui/core/IconButton';
import DeleteOutlineOutlinedIcon from '@material-ui/icons/DeleteOutlineOutlined';
import './listadofotos.css'

const useStyles = makeStyles((theme) => ({
  root: {
    display: 'flex',
    flexWrap: 'wrap',
    justifyContent: 'space-around',
    overflow: 'hidden',
    backgroundColor: theme.palette.background.paper,
  },
  gridList: {
    width: '100%',
    height: '100%',
  },
  icon: {
    color: 'rgba(255, 255, 255, 0.54)',
  },

}));

export default function TitlebarGridList(props) {

    const classes = useStyles();

    const {urls,titulo} = props
    const [fotos, setfotos] = React.useState([])

    React.useEffect(() => {   
        const todasFotos = require('axios'); 
        /**
         * solo las fotos que necesitamos
         */
        // Make a request for a user with a given ID
        todasFotos.get(urls)
        .then(function (response) {
            // handle success 
            setfotos(response.data[0].mensaje)
        })
        .catch(function (error) {
            // handle error
            alert(error)
        })
        .finally(function () {
            // always executed
        });
        
    },[])

    function obtenerUrl(texto) {
        let cadena = "";
        cadena = 'http://apptourguide.ddns.net/TourGuide/fotos/mapa/';
        let arraypenco = texto.split('/')    
        cadena+=arraypenco[0]+'.png'

        return cadena
    }

    function obtenerTitulo(texto) {
        let cadena = "";
        if(typeof texto === 'string'){
            if(texto.includes('/')){
                let arraypenco = texto.split('/')    
                cadena+=arraypenco[0]     
            }else{
                cadena = null
            }                   
        }        
        return cadena
    }

    function borrarFoto(foto) {
        let mensaje = "";
        fetch('http://apptourguide.ddns.net/TourGuide/fotos/leer.php')
        .then((response) => {
            fetch('http://apptourguide.ddns.net/TourGuide/fotos/reiniciarfotos.php')
            for(let i=0; i!=response[0].mensaje.length; i++){            
                if(typeof response[0].mensaje[i] === 'string'){                
                    if(response[0].mensaje[i].split('/')[0]!== foto){
                        mensaje += (response[0].mensaje[i]+',')
                    }
                }
            }
            console.log(mensaje + ' mensaje')
            fetch('http://apptourguide.ddns.net/TourGuide/fotos/registrarreact.php?mensaje='+mensaje)
        })
        
    }

    function cargar(tile,index){
        if(typeof tile !== 'boolean'){
            if(tile !== "\r\n"){
                return(
                    <GridListTile key={index} className={classes.gridList}>
                            <img src={obtenerUrl(tile)} alt={obtenerUrl(tile)} />
                            <GridListTileBar
                                title={obtenerTitulo(tile)}
                                actionIcon={
                                    <IconButton  className={classes.icon}>
                                    <DeleteOutlineOutlinedIcon onClick={()=>alert('actualmente no funciono')} />
                                    </IconButton>
                                }
                            />
                    </GridListTile>
                )
            }            
        }        
    }


    return (

        <div className={classes.root}>
        <label>{titulo}</label>
            <GridList cellHeight={360} className={classes.gridList}>
                <GridListTile  key="Subheader" cols={2} style={{ height: 'auto' }}>
                </GridListTile>
                {fotos.map((tile,index) => (
                    cargar(tile,index)
                ))}
            </GridList>
        </div>
    );
}