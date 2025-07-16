import { useState } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'

function App() {
  function saludar() {
    alert('Hola, soy JavaScript puro');
  }

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold text-blue-500">Hola React + Tailwind</h1>
      <button
        className="mt-4 bg-green-500 text-white px-4 py-2 rounded"
        onClick={saludar}
      >
        Salúdame
      </button>
    </div>
  );
}

export default App;
