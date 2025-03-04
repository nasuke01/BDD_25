import React, { useEffect, useState } from "react";

const Classement = () => {
    const [candidats, setCandidats] = useState([]);

    const fetchData = () => {
        fetch("/api/statistiques")
            .then((response) => response.json())
            .then((data) => {
                console.log("Données reçues :", data);
                setCandidats(data);
            })
            .catch((error) => console.error("Erreur de récupération :", error));
    };

    useEffect(() => {
        fetchData(); // Chargement initial
        const interval = setInterval(fetchData, 5000); // Rafraîchissement toutes les 5 secondes
        return () => clearInterval(interval);
    }, []);

    return (
        <div>
            <h1>Classement des Candidats</h1>
            {candidats.length === 0 ? (
                <p>Aucun parrainage enregistré pour le moment.</p>
            ) : (
                <table border="1">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Nom</th>
                            <th>Parti</th>
                            <th>Nombre de Parrainages</th>
                        </tr>
                    </thead>
                    <tbody>
                        {candidats.map((candidat, index) => (
                            <tr key={candidat.id}>
                                <td>{index + 1}</td>
                                <td>{candidat.user?.nom} {candidat.user?.prenom}</td>
                                <td>{candidat.parti_politique || "Indépendant"}</td>
                                <td>{candidat.parrainages_count}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
};

export default Classement;
