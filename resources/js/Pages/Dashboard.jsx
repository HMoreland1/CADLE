import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import LearningContentRepeater from "@/Components/LearningContentRepeater.jsx";
import ProgressBar from '@/Components/ProgressBar.jsx';
import {useEffect, useState} from "react";
import axios from 'axios'; // Import axios


export default function Dashboard({ auth }) {

    const [essentialProgress, setEssentialProgress] = useState(0);
    const [complianceProgress, setComplianceProgress] = useState(0);
    const [developmentProgress, setDevelopmentProgress] = useState(0);
    useEffect(() => {
        // Assuming fetchData is a function to fetch user's progress data


        const fetchData = async () => {
            try {
                const response = await axios.get(`/api/learning-content/user/${auth.user.id}/status`);
                const { Essential, Compliance, Development } = response.data;
                console.log(response.data)
                console.log(Compliance)
                console.log(Development)
                setEssentialProgress(Essential);
                setComplianceProgress(Compliance);
                setDevelopmentProgress(Development);
            } catch (error) {
                console.error('Error fetching user progress:', error);
            }
        };

        fetchData();
    }, [auth.user.id]); // Fetch data whenever the user ID changes




    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-bold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="mx-auto sm:px-6 lg:px-8" style={{ width: '70%' }}>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <h1 className="p-6 font-bold text-gray-900">Completion Status:</h1>
                        <div className="flex items-center">
                            <div className="w-1/3 p-6">
                                <h1 className="font-bold text-gray-900">Essential</h1>
                                <ProgressBar percentage={essentialProgress}/>
                            </div>
                            <div className="w-1/3 p-6">
                                <h1 className="font-bold text-gray-900">Compliance</h1>
                                <ProgressBar percentage={complianceProgress}/>
                            </div>
                            <div className="w-1/3 p-6">
                                <h1 className="font-bold text-gray-900">Development</h1>
                                <ProgressBar percentage={developmentProgress}/>
                            </div>
                        </div>
                        <div className={"p-6"}>
                            <h2 style={{fontWeight: 'bold', marginBottom: '5px'}}>Compliance and Essential Training</h2>
                            <div style={{marginBottom: '20px'}}>Please complete these training modules before moving on
                                to
                                anything else
                            </div>
                            <LearningContentRepeater userId={auth.user.id} showFilterByDefault={false}/>
                        </div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
