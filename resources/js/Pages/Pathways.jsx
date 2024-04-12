import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import LearningContentRepeater from "@/Components/LearningContentRepeater.jsx";
import axios from 'axios'; // Import axios for making HTTP requests

export default function Pathways({ auth }) {
    const [pathways, setPathways] = useState([]);

    useEffect(() => {
        // Fetch pathways data when component mounts
        axios.get('/api/pathways') // Adjust the API endpoint as per your setup
            .then(response => {
                setPathways(response.data);
            })
            .catch(error => {
                console.error('Error fetching pathways:', error);
            });
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Pathways</h2>}
            page_description={<h2 className="font-semibold text-xs text-gray-800 leading-tight">Develop your expertise in specific topics by following these skill pathways</h2>}
        >
            <Head title="Catalogue"/>

            <div className="py-6">
                <div className="mx-auto sm:px-6 lg:px-8" style={{width: '70%'}}>
                    {pathways.map(pathway => (
                        <div key={pathway.id} className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div className="p-4">
                                <h2 className="font-semibold text-lg text-gray-800 leading-tight mb-2">{pathway.name}</h2>
                                <p className="text-gray-600 mb-4">{pathway.description}</p>
                                <LearningContentRepeater assignedContentIds={pathway} fillWindow={false}/>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
