import { useState } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'

import NoticiasLista from "./noticiasLista";
//import NoticiasDetalle from './NoticiasDetalle'

function App() {
  return (
    <div className="max-w-3xl mx-auto mt-8">
      <NoticiasLista />
    </div>
  );
}

export default App;
