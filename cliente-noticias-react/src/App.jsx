// src/App.jsx
import { useState } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import NoticiasLista from "./noticiasLista";
import Header from "./components/Header";
import Footer from "./components/Footer";
import Registro from "./pages/Registro";
import Login from "./pages/Login";
// ... otros imports

function App() {
  const [user, setUser] = useState(() => {
    const userGuardado = localStorage.getItem("user");
    return userGuardado ? JSON.parse(userGuardado) : null;
  }); // o traer desde localStorage si ya hay login persistente

  const handleLogout = () => {
    localStorage.removeItem("token");
    setUser(null);
  };

  return (
    <Router>
      <Header user={user} onLogout={handleLogout} />
      <main className="min-h-screen">
        <Routes>
          <Route path="/" element={<NoticiasLista />} />
          <Route path="/registro" element={<Registro />} />
          <Route path="/login" element={<Login />} />
          {/* otras rutas */}
        </Routes>
      </main>
      <Footer />
    </Router>
  );
}

export default App;