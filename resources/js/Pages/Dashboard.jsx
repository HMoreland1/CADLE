import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import LearningContentRepeater from "@/Components/LearningContentRepeater.jsx";
import ProgressBar from '@/Components/ProgressBar.jsx';

export default function Dashboard({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <h1 className="p-6 font-bold text-gray-900">My Progress!</h1>
                        <div className="flex items-center">
                            <div className="w-1/3 p-6">
                                <h1 className="font-bold text-gray-900">Essential</h1>
                                <ProgressBar percentage="50"/>
                            </div>
                            <div className="w-1/3 p-6">
                                <h1 className="font-bold text-gray-900">Compliance</h1>
                                <ProgressBar percentage="70"/>
                            </div>
                            <div className="w-1/3 p-6">
                                <h1 className="font-bold text-gray-900">Development</h1>
                                <ProgressBar percentage="85"/>
                            </div>
                        </div>
                        <div className={"p-6 "}>
                            <h2 style={{fontWeight: 'bold', marginBottom: '5px'}}>Compliance and Essential Training</h2>
                            <div style={{marginBottom: '20px'}}>Please complete these training modules before moving on
                                to
                                anything else
                            </div>
                            <LearningContentRepeater userId={auth.user.id} showFilterByDefault={true} />
                        </div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
