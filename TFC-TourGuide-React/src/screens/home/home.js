import React from 'react';
import PropTypes from 'prop-types';
import { makeStyles } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';
import Typography from '@material-ui/core/Typography';
import Box from '@material-ui/core/Box';
import Tabla from '../../components/tabla'
import ListadoFotos from '../../components/ListadoFotos'
import { Redirect } from "react-router-dom"
import './home.css'
import PeopleIcon from '@material-ui/icons/People';
import PageviewIcon from '@material-ui/icons/Pageview';
import ReceiptIcon from '@material-ui/icons/Receipt';
import PhotoIcon from '@material-ui/icons/Photo';
import ReportIcon from '@material-ui/icons/Report';
import ArrowBackIcon from '@material-ui/icons/ArrowBack';

function TabPanel(props) {
    const { children, value, index, ...other } = props;
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`scrollable-force-tabpanel-${index}`}
      aria-labelledby={`scrollable-force-tab-${index}`}
      {...other}
    >
      {value === index && (
        <Box p={3}>
          <Typography>{children}</Typography>
        </Box>
      )}
    </div>
  );
}

TabPanel.propTypes = {
  children: PropTypes.node,
  index: PropTypes.any.isRequired,
  value: PropTypes.any.isRequired,
};

function a11yProps(index) {
  return {
    id: `scrollable-force-tab-${index}`,
    'aria-controls': `scrollable-force-tabpanel-${index}`,
  };
}

const useStyles = makeStyles((theme) => ({
  root: {
    flexGrow: 1,
    width: '100%',
    backgroundColor: theme.palette.background.paper,
  },
}));

export default function ScrollableTabsButtonForce(props) {
    const classes = useStyles();
    const [value, setValue] = React.useState(0);    


  let correcto
  
  /**
   * Recibe un true si has accedico con usuarios y contraseña correctos, prevee que pongan en la url home y puedan entrar
   */
  if(props!==undefined){
      correcto = props.location.state;
  }

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  return (
    <div className={classes.root}>
      <AppBar position="static" color="default">
        <Tabs
          value={value}
          onChange={handleChange}
          variant="scrollable"
          scrollButtons="on"
          indicatorColor="primary"
          textColor="primary"
          aria-label="scrollable force tabs example"
        >
          <Tab label="Todos los usuarios" icon={<PeopleIcon />} {...a11yProps(0)} />
          <Tab label="Todos los anuncios" icon={<PageviewIcon />} {...a11yProps(1)} />
          <Tab label="Todas las propuestas" icon={<ReceiptIcon />} {...a11yProps(2)} />
          <Tab label="Todas las fotos" icon={<PhotoIcon />} {...a11yProps(3)} />
          <Tab label="Fotos reportadas" icon={<ReportIcon />} {...a11yProps(4)} />
          <Tab label="Cerrar Sesión" icon={<ArrowBackIcon />} {...a11yProps(5)} href="/" />
        </Tabs>
      </AppBar>
      <TabPanel value={value} index={0}>
        <Tabla 
            nombretabla={'Todos los usuarios'} 
            url={'http://apptourguide.ddns.net/TourGuide/obtenerUsuarios.php'} 
            headCells = {
                [
                    { id: 'ID', numeric: false, disablePadding: true, label: 'ID' },
                    { id: 'Token', numeric: true, disablePadding: false, label: 'Token' },
                    { id: 'nombre', numeric: true, disablePadding: false, label: 'Nombre' },
                    { id: 'Apellidos', numeric: true, disablePadding: false, label: 'Apellidos' },
                    { id: 'Email', numeric: true, disablePadding: false, label: 'Email' },
                    { id: 'Puntuacion', numeric: true, disablePadding: false, label: 'Puntuacion' },
                    { id: 'Ciudad', numeric: true, disablePadding: false, label: 'Ciudad' },
                    { id: 'Provincia', numeric: true, disablePadding: false, label: 'Provincia' },
                ]
            } 
            celdas= {['ID','Token','Nombre','Apellidos','Email','puntuacion','ciudad','nombreProvincia']} >
        </Tabla>
      </TabPanel>
      <TabPanel value={value} index={1}>
        <Tabla 
            nombretabla={'Todos los Anuncios'} 
            url={'http://apptourguide.ddns.net/TourGuide/obtenerTodosAnuncios.php'} 
            headCells = {[
                        { id: 'Estado', numeric: false, disablePadding: true, label: 'Estado' },
                        { id: 'ID', numeric: true, disablePadding: false, label: 'ID' },
                        { id: 'NombreViaje', numeric: true, disablePadding: false, label: 'Nombre del viaje' },
                        { id: 'Acompanantes', numeric: true, disablePadding: false, label: 'Acompanantes' },
                        { id: 'FechaCreacion', numeric: true, disablePadding: false, label: 'Fecha Creacion' },
                        { id: 'FechaInicio', numeric: true, disablePadding: false, label: 'Fecha Inicio' },
                        { id: 'FechaFin', numeric: true, disablePadding: false, label: 'Fecha Fin' },
                        { id: 'Mensaje', numeric: true, disablePadding: false, label: 'Mensajes' },
                        { id: 'nombreCiudad', numeric: true, disablePadding: false, label: 'Ciudad' },
                        { id: 'nombreInteres', numeric: true, disablePadding: false, label: 'Intereses' },
                        ]} 
            celdas= {['Estado','ID','NombreViaje','Acompanantes','FechaCreacion','FechaInicio','FechaFin','Mensaje','nombreCiudad','nombreInteres']} >
        </Tabla>
      </TabPanel>
      <TabPanel value={value} index={2}>
        <Tabla 
            nombretabla={'Todas las Propuestas'} 
            url={'http://apptourguide.ddns.net/TourGuide/obtenerPropuestas.php'} 
            headCells = {[
                        { id: 'ID', numeric: false, disablePadding: true, label: 'ID' },
                        { id: 'IDGuia', numeric: true, disablePadding: false, label: 'IDGuia' },
                        { id: 'IDAnuncio', numeric: true, disablePadding: false, label: 'IDAnuncio' },
                        { id: 'Mensaje', numeric: true, disablePadding: false, label: 'Mensaje' },
                        { id: 'Estado', numeric: true, disablePadding: false, label: 'Estado' },
                    ]} 
            celdas= {['ID','IDGuia','IDAnuncio','Mensaje','Estado']} >
        </Tabla>
      </TabPanel>
      <TabPanel value={value} index={3}>
        <ListadoFotos titulo={'Todas las fotos'} urls={'http://apptourguide.ddns.net/TourGuide/fotos/leer.php'} ></ListadoFotos>
      </TabPanel>
      <TabPanel value={value} index={4}>
        <ListadoFotos titulo={'Fotos reportadas'} urls={'http://apptourguide.ddns.net/TourGuide/fotos/leerincidencias.php'} ></ListadoFotos>
      </TabPanel>
      {!correcto && <Redirect to= '/'/>}  
    </div>
  );
}