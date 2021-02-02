import React, {useState} from 'react';
import './tvinput.css'

const TvInput = props =>{
    
    const { texto, imagen, handle, type } = props
    
    return(
        
        <div className="div-tvinput">
            <img className="img-tvinput" alt={texto} src={imagen}/>
            <input type={type} className="input-tvinput" placeholder={texto} onChange={handle} />
        </div>
    )

}

export default TvInput;