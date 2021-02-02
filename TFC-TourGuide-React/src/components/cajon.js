import React from 'react';
import clsx from 'clsx';
import { makeStyles, useTheme } from '@material-ui/core/styles';
import Drawer from '@material-ui/core/Drawer';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import List from '@material-ui/core/List';
import CssBaseline from '@material-ui/core/CssBaseline';
import Typography from '@material-ui/core/Typography';
import Divider from '@material-ui/core/Divider';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import ChevronLeftIcon from '@material-ui/icons/ChevronLeft';
import ChevronRightIcon from '@material-ui/icons/ChevronRight';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import WarningOutlinedIcon from '@material-ui/icons/WarningOutlined';
import FindInPageOutlinedIcon from '@material-ui/icons/FindInPageOutlined';
import CardTravelOutlinedIcon from '@material-ui/icons/CardTravelOutlined';
import SaveAltOutlinedIcon from '@material-ui/icons/SaveAltOutlined';
import PersonOutlineOutlinedIcon from '@material-ui/icons/PersonOutlineOutlined';
import CameraAltOutlinedIcon from '@material-ui/icons/CameraAltOutlined';

const drawerWidth = 240;

const useStyles = makeStyles((theme) => ({
  root: {
    display: 'flex',
  },
  appBar: {
    zIndex: theme.zIndex.drawer + 1,
    transition: theme.transitions.create(['width', 'margin'], {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.leavingScreen,
    }),
  },
  appBarShift: {
    marginLeft: drawerWidth,
    width: `calc(100% - ${drawerWidth}px)`,
    transition: theme.transitions.create(['width', 'margin'], {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.enteringScreen,
    }),
  },
  menuButton: {
    marginRight: 36,
  },
  hide: {
    display: 'none',
  },
  drawer: {
    width: drawerWidth,
    flexShrink: 0,
    whiteSpace: 'nowrap',
  },
  drawerOpen: {
    width: drawerWidth,
    transition: theme.transitions.create('width', {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.enteringScreen,
    }),
  },
  drawerClose: {
    transition: theme.transitions.create('width', {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.leavingScreen,
    }),
    overflowX: 'hidden',
    width: theme.spacing(7) + 1,
    [theme.breakpoints.up('sm')]: {
      width: theme.spacing(9) + 1,
    },
  },
  toolbar: {
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'flex-end',
    padding: theme.spacing(0, 1),
    // necessary for content to be below app bar
    ...theme.mixins.toolbar,
  },
  content: {
    flexGrow: 1,
    padding: theme.spacing(3),
  },
}));


export default function MiniDrawer(props) {
  const classes = useStyles();
  const theme = useTheme();
  const [open, setOpen] = React.useState(false);
  /**
   * Le entra que componente queremos incrustarle dentro al cajon para poder usarlo con varias cosas dentro en este caso es la tabla
   * Elementos es el nombre que tendra cada uno de las pestañas
   * click es un callback para controlar el evento click desde el padre
   */
  const { componente, elementos, click} = props
  /**
   * pone un icono en funcion del index, esto si que es mas manual ya que depende de los elementos que le pasesmos por props el 0 sera
   * el primero, etc para que coincida icono con texto
   * Tiene un id Usuarios para identificar en que boton se ha clicado, si no estuviese no sabria si se ha clicado en anuncios o en viajes
   * @param index define por donde va montando 
   */
  function ponericono(index){
    let componente = <label>Fallaponericono</label>
    switch (index) {
      case 0:
        componente=<PersonOutlineOutlinedIcon key={index} onClick={click} id='Usuarios'/>
        break;
      case 1:
        componente=<FindInPageOutlinedIcon key={index} onClick={click} id='Anuncios'/>
        break;
      case 2:
        componente=<CardTravelOutlinedIcon key={index} onClick={click} id='Viajes' />
        break;
      case 3:
        componente=<SaveAltOutlinedIcon key={index} onClick={click} id='Propuestas' />
        break;
      case 4:
        componente=<CameraAltOutlinedIcon key={index} onClick={click} id='Fotos'/>
        break;        
      case 5:
        componente=<WarningOutlinedIcon key={index} onClick={click} id='FotosReportadas'/>
        break;
      default:
        break;
    }
    return componente;
  }

  const handleDrawerOpen = () => {
    setOpen(true);
  };

  const handleDrawerClose = () => {
    setOpen(false);
  };

  return (
    <div className={classes.root}>
      <CssBaseline />
      <AppBar
        position="fixed"
        className={clsx(classes.appBar, {
          [classes.appBarShift]: open,
        })}
      >
        <Toolbar>
          <IconButton
            color="inherit"
            aria-label="open drawer"
            onClick={handleDrawerOpen}
            edge="start"
            className={clsx(classes.menuButton, {
              [classes.hide]: open,
            })}
          >
            <MenuIcon />
          </IconButton>
          <Typography variant="h6" noWrap>
            Administración TourGuide
          </Typography>
        </Toolbar>
      </AppBar>
      <Drawer
        variant="permanent"
        className={clsx(classes.drawer, {
          [classes.drawerOpen]: open,
          [classes.drawerClose]: !open,
        })}
        classes={{
          paper: clsx({
            [classes.drawerOpen]: open,
            [classes.drawerClose]: !open,
          }),
        }}
      >
        <div className={classes.toolbar}>
          <IconButton onClick={handleDrawerClose}>
            {theme.direction === 'rtl' ? <ChevronRightIcon /> : <ChevronLeftIcon />}
          </IconButton>
        </div>
        <Divider />
        <List>
          {elementos.map((text, index) => (
            <ListItem button key={text}>
              <ListItemIcon onClick={click} id={elementos[index]}>
                {ponericono(index)}
              </ListItemIcon>
              <ListItemText primary={text} />
            </ListItem>
          ))}
        </List>    
      </Drawer>
      <main className={classes.content}>
        <div className={classes.toolbar} />
            {componente}
      </main>
    </div>
  );
}
