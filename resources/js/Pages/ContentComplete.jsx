
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function ContentComplete({ auth, content, quiz, score, val}) {
    const { pass_marks, total_marks} = quiz;
    const passed = score >= pass_marks; // Check if the user passed the quiz
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Success</h2>}
            page_description={<h2 className="font-semibold text-xs text-gray-800 leading-tight">You have completed this training module. Your score: {score} / {total_marks}</h2>} // Display user's score
        >
            <Head title={passed ? "Success" : "Failure"} /> {/* Set the title based on pass/fail */}

            <div className="py-6">
                <div className="mx-auto sm:px-6 lg:px-8" style={{ width: '70%' }}>
                    {passed ? (
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div className="p-4">
                                <h2 className="font-semibold text-lg text-gray-800 leading-tight mb-2">{content.name}</h2>
                                <p className="text-gray-600 mb-4">Congratulations, you have successfully completed this training module.</p>
                                <p className="text-gray-600 mb-4">You may now return to the dashboard.</p>
                            </div>
                        </div>
                    ) : ( /* Render failure message if failed */
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div className="p-4">
                                <h2 className="font-semibold text-lg text-gray-800 leading-tight mb-2">{content.name}</h2>
                                <p className="text-gray-600 mb-4">Unfortunately, you did not pass this training module.</p>
                                <p className="text-gray-600 mb-4">You may review the content and retake the quiz.</p>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
