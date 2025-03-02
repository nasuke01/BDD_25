import React, { useEffect, useState } from "react";

const Classement = () => {
    const [candidats, setCandidats] = useState([]);

    useEffect(() => {
        fetch("/api/statistiques")
            .then((response) => response.json())
            .then((data) => setCandidats(data))
            .catch((error) => console.error("Erreur de récupération :", error));
    }, []);

    return (
        <div>
            <h1>Classement des Candidats</h1>
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
                            <td>{candidat.user.nom} {candidat.user.prenom}</td>
                            <td>{candidat.parti_politique}</td>
                            <td>{candidat.parrainages_count}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default Classement;
