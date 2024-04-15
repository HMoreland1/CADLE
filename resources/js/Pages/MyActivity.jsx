import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function MyActivity({ auth }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">My Activity</h2>}
            page_description={<h2 className="font-semibold text-xs text-gray-800 leading-tight">Find modules you’re halfway through, completed, or content that has been assigned to you.</h2>}
        >
            <Head title="My Activity"/>

            <div className="py-6">
            </div>
        </AuthenticatedLayout>
    );
}
