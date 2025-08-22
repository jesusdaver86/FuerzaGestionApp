import React, { useState, useEffect } from 'react';
import { initializeApp } from 'firebase/app';
import { getFirestore, collection, addDoc, getDocs, query, where } from 'firebase/firestore';

// Configuración de Firebase
const firebaseConfig = {
    apiKey: "AIzaSyC67C_nUyWHgQTJeQL8HLt6cwU854Og064",
    authDomain: "blogapp-a6dd9.firebaseapp.com",
    projectId: "blogapp-a6dd9",
    storageBucket: "blogapp-a6dd9.firebasestorage.app",
    messagingSenderId: "433550976940",
    appId: "1:433550976940:web:5302928d1e50c719aefc09"
};

// Inicializar Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// Componente para el formulario de registro
const RegistroForm = ({ onRegister }) => {
    const [cedula, setCedula] = useState('');
    const [nombres, setNombres] = useState('');
    const [apellidos, setApellidos] = useState('');
    const [correo, setCorreo] = useState('');
    const [telefono, setTelefono] = useState('');
    const [fechaInscripcion, setFechaInscripcion] = useState(new Date().toISOString().split('T')[0]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        
        // Validaciones
        if (!/^\d+$/.test(cedula)) {
            alert('La cédula debe contener solo números');
            return;
        }
        
        if (!nombres.trim() || !apellidos.trim()) {
            alert('Los nombres y apellidos son obligatorios');
            return;
        }

        if (correo && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
            alert('Por favor ingrese un correo electrónico válido');
            return;
        }

        if (telefono && !/^[\d\s+\-()]+$/.test(telefono)) {
            alert('Por favor ingrese un número de teléfono válido');
            return;
        }

        try {
            // Agregar el nuevo registro a la colección 'registros'
            await addDoc(collection(db, "registros"), {
                cedula: cedula,
                nombres: nombres.trim(),
                apellidos: apellidos.trim(),
                correo: correo.trim(),
                telefono: telefono.trim(),
                fechaInscripcion: fechaInscripcion,
                timestamp: new Date()
            });
            
            alert('Registro exitoso!');
            // Reiniciar formulario
            setCedula('');
            setNombres('');
            setApellidos('');
            setCorreo('');
            setTelefono('');
            setFechaInscripcion(new Date().toISOString().split('T')[0]);
            onRegister(); // Actualizar la lista después de un nuevo registro
        } catch (error) {
            console.error("Error al agregar documento: ", error);
            alert('Error al registrar. Por favor, intente nuevamente.');
        }
    };

    return (
        <form onSubmit={handleSubmit} className="p-4 bg-gray-100 rounded-lg shadow-md">
            <h2 className="text-xl font-bold mb-4">Formulario de Registro</h2>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="mb-4">
                    <label htmlFor="cedula" className="block text-sm font-medium text-gray-700">Cédula *</label>
                    <input
                        type="text"
                        id="cedula"
                        value={cedula}
                        onChange={(e) => setCedula(e.target.value)}
                        required
                        pattern="[0-9]+"
                        title="La cédula debe contener solo números"
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                </div>
                
                <div className="mb-4">
                    <label htmlFor="fechaInscripcion" className="block text-sm font-medium text-gray-700">Fecha de Inscripción *</label>
                    <input
                        type="date"
                        id="fechaInscripcion"
                        value={fechaInscripcion}
                        onChange={(e) => setFechaInscripcion(e.target.value)}
                        required
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="mb-4">
                    <label htmlFor="nombres" className="block text-sm font-medium text-gray-700">Nombres *</label>
                    <input
                        type="text"
                        id="nombres"
                        value={nombres}
                        onChange={(e) => setNombres(e.target.value)}
                        required
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                </div>
                
                <div className="mb-4">
                    <label htmlFor="apellidos" className="block text-sm font-medium text-gray-700">Apellidos *</label>
                    <input
                        type="text"
                        id="apellidos"
                        value={apellidos}
                        onChange={(e) => setApellidos(e.target.value)}
                        required
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="mb-4">
                    <label htmlFor="correo" className="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input
                        type="email"
                        id="correo"
                        value={correo}
                        onChange={(e) => setCorreo(e.target.value)}
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                </div>
                
                <div className="mb-4">
                    <label htmlFor="telefono" className="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input
                        type="tel"
                        id="telefono"
                        value={telefono}
                        onChange={(e) => setTelefono(e.target.value)}
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                </div>
            </div>
            
            <button
                type="submit"
                className="w-full px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Registrar
            </button>
        </form>
    );
};

// Componente para búsqueda avanzada
const BusquedaAvanzada = ({ onSearch }) => {
    const [filtro, setFiltro] = useState('todos');
    const [termino, setTermino] = useState('');

    const handleSearch = () => {
        onSearch(filtro, termino);
    };

    const handleClear = () => {
        setTermino('');
        setFiltro('todos');
        onSearch('todos', '');
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow-md mb-4">
            <h3 className="text-lg font-semibold mb-3">Búsqueda Avanzada</h3>
            <div className="flex flex-col md:flex-row gap-4 items-end">
                <div className="flex-1">
                    <label htmlFor="filtro" className="block text-sm font-medium text-gray-700">Buscar por:</label>
                    <select
                        id="filtro"
                        value={filtro}
                        onChange={(e) => setFiltro(e.target.value)}
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="todos">Todos los campos</option>
                        <option value="cedula">Cédula</option>
                        <option value="nombres">Nombres</option>
                        <option value="apellidos">Apellidos</option>
                        <option value="correo">Correo Electrónico</option>
                        <option value="telefono">Teléfono</option>
                    </select>
                </div>
                
                <div className="flex-1">
                    <label htmlFor="termino" className="block text-sm font-medium text-gray-700">Término de búsqueda:</label>
                    <input
                        type="text"
                        id="termino"
                        value={termino}
                        onChange={(e) => setTermino(e.target.value)}
                        placeholder="Ingrese su búsqueda..."
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                </div>
                
                <div className="flex gap-2">
                    <button
                        type="button"
                        onClick={handleSearch}
                        className="px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Buscar
                    </button>
                    <button
                        type="button"
                        onClick={handleClear}
                        className="px-4 py-2 bg-gray-300 text-gray-700 rounded-md shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                    >
                        Limpiar
                    </button>
                </div>
            </div>
        </div>
    );
};

// Componente para mostrar y buscar los registros
const ConsultaList = ({ refreshKey }) => {
    const [registros, setRegistros] = useState([]);
    const [registrosFiltrados, setRegistrosFiltrados] = useState([]);
    const [cargando, setCargando] = useState(true);

    useEffect(() => {
        const fetchRegistros = async () => {
            try {
                setCargando(true);
                const querySnapshot = await getDocs(collection(db, "registros"));
                const listaRegistros = querySnapshot.docs.map(doc => ({
                    id: doc.id,
                    ...doc.data()
                }));
                setRegistros(listaRegistros);
                setRegistrosFiltrados(listaRegistros);
            } catch (error) {
                console.error("Error al obtener documentos: ", error);
            } finally {
                setCargando(false);
            }
        };

        fetchRegistros();
    }, [refreshKey]);

    const handleSearch = async (filtro, termino) => {
        if (!termino.trim() || filtro === 'todos') {
            // Búsqueda general en todos los campos
            const resultados = registros.filter(reg =>
                Object.values(reg).some(val => 
                    val && val.toString().toLowerCase().includes(termino.toLowerCase())
                )
            );
            setRegistrosFiltrados(resultados);
            return;
        }

        // Búsqueda específica por campo
        const resultados = registros.filter(reg =>
            reg[filtro] && reg[filtro].toString().toLowerCase().includes(termino.toLowerCase())
        );
        setRegistrosFiltrados(resultados);
    };

    if (cargando) {
        return (
            <div className="p-4 bg-gray-100 rounded-lg shadow-md mt-8">
                <div className="flex justify-center items-center py-8">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                    <span className="ml-3 text-gray-600">Cargando registros...</span>
                </div>
            </div>
        );
    }

    return (
        <div className="p-4 bg-gray-100 rounded-lg shadow-md mt-8">
            <h2 className="text-xl font-bold mb-4">Consulta de Registros</h2>
            
            <BusquedaAvanzada onSearch={handleSearch} />
            
            <div className="bg-white rounded-lg shadow overflow-hidden">
                {registrosFiltrados.length > 0 ? (
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cédula</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombres</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellidos</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Inscripción</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {registrosFiltrados.map(reg => (
                                    <tr key={reg.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{reg.cedula}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{reg.nombres}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{reg.apellidos}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{reg.correo || '-'}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{reg.telefono || '-'}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{reg.fechaInscripcion}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="text-center py-8">
                        <p className="text-gray-500 text-lg">No se encontraron registros.</p>
                        <p className="text-gray-400 text-sm">Intente con otros términos de búsqueda.</p>
                    </div>
                )}
                
                <div className="bg-gray-50 px-4 py-3 sm:px-6">
                    <p className="text-sm text-gray-700">
                        Mostrando <span className="font-medium">{registrosFiltrados.length}</span> de <span className="font-medium">{registros.length}</span> registros
                    </p>
                </div>
            </div>
        </div>
    );
};

// Componente principal de la aplicación
export default function App() {
    const [refreshKey, setRefreshKey] = useState(0);

    const handleNewRegistration = () => {
        setRefreshKey(prevKey => prevKey + 1);
    };

    return (
        <div className="min-h-screen bg-gray-50 p-4 sm:p-6">
            <div className="max-w-6xl mx-auto">
                <div className="bg-white p-6 sm:p-8 rounded-xl shadow-2xl">
                    <h1 className="text-3xl font-extrabold text-center mb-6 text-gray-800">Sistema de Registro y Consulta</h1>
                    <RegistroForm onRegister={handleNewRegistration} />
                    <ConsultaList refreshKey={refreshKey} />
                </div>
            </div>
        </div>
    );
}