import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import LearningContentRepeater from "@/Components/LearningContentRepeater.jsx";

export default function MyActivity({ auth }) {
    console.log("USER ID: ", auth.user.id)
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">My Activity</h2>}
            page_description={<h2 className="font-semibold text-xs text-gray-800 leading-tight">Find all the modules that you have completed.</h2>}
        >
            <Head title="My Activity"/>

            <div className="py-6">
                <div className="mx-auto sm:px-6 lg:px-8" style={{width: '70%'}}>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                        <div className={"p-4"}>
                            <LearningContentRepeater userId={auth.user.id} complete={true} fillWindow={true}/>

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
