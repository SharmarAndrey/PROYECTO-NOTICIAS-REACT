// src/NoticiasLista.jsx
import { useEffect, useState } from "react";

export default function NoticiasLista() {
  const [noticias, setNoticias] = useState([]);
  const [comienzo, setComienzo] = useState(0);
  const [loading, setLoading] = useState(false);
  const [hayMas, setHayMas] = useState(true);
  const API_URL = import.meta.env.VITE_API_URL;
  const cargarNoticias = async () => {
    if (loading || !hayMas) return;
    setLoading(true);

    try {
      const res = await fetch(`${API_URL}api/?comienzo=${comienzo}`);
      const data = await res.json();

      if (data.length === 0) {
        setHayMas(false);
      } else {
        setNoticias((prev) => [...prev, ...data]);
        setComienzo(comienzo + data.length);
      }
    } catch (err) {
      console.error("Error al cargar noticias:", err);
    }

    setLoading(false);
  };

  useEffect(() => {
    cargarNoticias();
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">Últimas Noticias</h1>

      <div className="grid gap-4">
        {noticias.map((n) => (
          <div key={n.id} className="p-4 border rounded shadow hover:shadow-md transition">
            <h2 className="text-lg font-semibold">{n.titulo}</h2>
            <p className="text-sm text-gray-600">Por {n.autor}</p>
          </div>
        ))}
      </div>

      {hayMas && (
        <button
          onClick={cargarNoticias}
          className="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
          disabled={loading}
        >
          {loading ? "Cargando..." : "Cargar más"}
        </button>
      )}
    </div>
  );
}