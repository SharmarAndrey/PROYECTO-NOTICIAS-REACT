// src/NoticiasLista.jsx
import { useEffect, useState, useRef } from "react";

export default function NoticiasLista() {
  const [noticias, setNoticias] = useState([]);
  const [comienzo, setComienzo] = useState(0);
  const [loading, setLoading] = useState(false);
  const [hayMas, setHayMas] = useState(true);
  // Usar la variable de entorno para la URL de la API
  // que tenemos en .env
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
        setNoticias((prev) => {
          // Evitar duplicados
          const nuevos = data.filter(n => !prev.some(p => p.id === n.id));
          return [...prev, ...nuevos];
        });
        setComienzo(comienzo + data.length);
      }
    } catch (err) {
      console.error("Error al cargar noticias:", err);
    }

    setLoading(false);
  };

  let mounted = true;
  useEffect(() => {

    if (mounted) {
      cargarNoticias();
    }
    return () => {
      mounted = false;
    };
  }, []);

  // Usamos un ref para el elemento de carga
  const loader = useRef(null);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting && hayMas && !loading) {
          cargarNoticias();
        }
      },
      { threshold: 1.0 }
    );

    const el = loader.current;
    if (el) observer.observe(el);

    return () => {
      if (el) observer.unobserve(el);
    };
  }, [loader, hayMas, loading]);

  return (
    <div className="p-4 max-w-4xl mx-auto">
      <h1 className="text-3xl font-bold mb-6">📰 Últimas Noticias</h1>

      <div className="grid md:grid-cols-2 gap-6">
        {noticias.map((n) => (
          <div key={n.id} className="p-4 border rounded shadow hover:shadow-md transition bg-white">
            <img
              src={API_URL + n.foto || "https://via.placeholder.com/600x300?text=Sin+imagen"}
              alt={n.titulo}
              className="w-full h-40 object-cover rounded mb-2"
            />
            <h2 className="text-xl font-semibold mb-1">{n.titulo}</h2>
            <p className="text-sm text-gray-600 mb-2">
              Por <span className="font-medium">{n.nombre}</span> · {n.fecha?.split(" ")[0]}
            </p>
            <a href={`/?categoria=${n.categoria}`} className="text-blue-600 text-sm block mb-2">
              #{n.categoria}
            </a>
            <a
              href={`/noticia/${n.id}`}
              className="inline-block text-sm text-blue-500 hover:underline"
            >
              Ver más →
            </a>
          </div>
        ))}
      </div>

      <div ref={loader} className="h-12 flex items-center justify-center">
        {loading && <p className="text-gray-500">Cargando...</p>}
      </div>
    </div>
  );
}