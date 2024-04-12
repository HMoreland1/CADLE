import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Pathways({ auth }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Help</h2>}
            page_description={<h2 className="font-semibold text-xs text-gray-800 leading-tight">Get in touch to report any issues or if you need any help.</h2>}
        >
            <Head title="Help"/>

            <div className="py-6">
            </div>
        </AuthenticatedLayout>
    );
}
