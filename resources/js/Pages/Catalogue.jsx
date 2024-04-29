import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import LearningContentRepeater from "@/Components/LearningContentRepeater.jsx";

export default function Catalogue({auth}) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Catalogue</h2>}
            page_description={<h2 className="font-semibold text-xs text-gray-800 leading-tight">Explore a vast range of
                additional training that isn’t mandatory, but may make your job role easier.</h2>}
        >
            <Head title="Catalogue"/>

            <div className="overflow-visible py-6">
                <div className="mx-auto overflow-visible sm:px-6 lg:px-8" style={{width: '70%'}}>
                    <div className="bg-white overflow-visible shadow-sm sm:rounded-lg">


                        <div className={"overflow-visible p-4"}>
                            <LearningContentRepeater showFilterByDefault={true} fillWindow={true}/>

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
