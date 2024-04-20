import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Content({ auth, learningContent }) {

    console.log(learningContent.content_id)
    return (
        <AuthenticatedLayout

            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{learningContent.title}</h2>}
            page_description={<h2
                className="font-semibold text-xs text-gray-800 leading-tight">{learningContent.description}</h2>}
        >
            <Head title="Content"/>

            <div className="py-6">
                <div className="mx-auto sm:px-6 lg:px-8" style={{width: '70%'}}>
                    <div
                        className="py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg items-center flex flex-col justify-center">
                        <div className="py-6">
                            <div dangerouslySetInnerHTML={{__html: learningContent.content}}/>

                        </div>
                        <a href={route('showQuiz', {quiz: learningContent.quiz_id, learningContent: learningContent.content_id})} className="py-3 px-3 text-white bg-navy-blue rounded-xl">
                            Take the quiz
                        </a>

                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
