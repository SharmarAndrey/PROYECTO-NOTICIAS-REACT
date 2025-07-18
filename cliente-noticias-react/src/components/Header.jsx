// src/components/Header.jsx
import { Link } from "react-router-dom";

export default function Header({ user, onLogout }) {
  return (
    <header className="bg-blue-600 text-white px-4 py-3 flex justify-between items-center">
      <h1 className="text-xl font-bold">
        <Link to="/">📰 Noticias</Link>
      </h1>

      <nav className="flex items-center gap-4">
        {user ? (
          <>
            <Link to="/crear" className="hover:underline">
              Añadir Noticia
            </Link>
            <span className="italic">Hola, {user.nombre}</span>
            <button onClick={onLogout} className="bg-white text-blue-600 px-2 py-1 rounded hover:bg-gray-100">
              Cerrar sesión
            </button>
          </>
        ) : (
          <>
            <Link to="/login" className="hover:underline">
              Iniciar sesión
            </Link>
            <Link to="/registro" className="hover:underline">
              Registrarse
            </Link>
          </>
        )}
      </nav>
    </header>
  );
}