import React, { useState } from 'react'
import fire from './../../config/firebase'
import BottomNavigationAction from '@material-ui/core/BottomNavigationAction'
import BottomNavigation from '@material-ui/core/BottomNavigation'
import RestoreIcon from '@material-ui/icons/Restore'
import FavoriteIcon from '@material-ui/icons/Favorite'
import LocationOnIcon from '@material-ui/icons/LocationOn'


export default function Login () {

    const user = fire.auth().currentUser
    
    const [Usuario, setUsuario] = useState(user)
    

    return(
        <div>
            <h1>{Usuario.uid}</h1>
            <button onClick={()=>fire.auth().signOut()}></button>
            <BottomNavigation showLabels >
                <BottomNavigationAction onClick={()=> alert('click')} label="Recents" icon={<RestoreIcon />} />
                <BottomNavigationAction label="Favorites" icon={<FavoriteIcon />} />
                <BottomNavigationAction label="Nearby" icon={<LocationOnIcon />} />
            </BottomNavigation>
        </div>
        
    )
}