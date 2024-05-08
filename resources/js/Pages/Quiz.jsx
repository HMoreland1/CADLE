
import {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import axios from 'axios';

export default function Quiz({ auth, quiz, content = null }) {
    const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);
    const [userAnswers, setUserAnswers] = useState({});
    const { id, name, pass_marks, total_marks, questions, quiz_questions} = quiz;
    const currentQuestion = questions[currentQuestionIndex];
    const [attemptId, setAttemptId] = useState();
    const [maxAttemptReached, setMaxAttemptReached] = useState(false);

    // Function to start the quiz attempt
    const startQuizAttempt = async () => {
        try {
            const response = await axios.post(`/api/quiz-attempts/user/${auth.user.id}/quiz/${id}/start`);
            setAttemptId(response.data.quiz_attempt.id);

        } catch (error) {
            setMaxAttemptReached(true);

        }
    };
    useEffect(() => {
    }, [attemptId]);

    useEffect(() => {
        // Start the quiz attempt when the component mounts
        startQuizAttempt();
    }, []); // Empty dependency array ensures this effect runs only once on mount

    const handleAnswerSelection = (optionId) => {
        setUserAnswers(prevAnswers => {
            return {
                ...prevAnswers,
                [currentQuestionIndex]: optionId
            };
        });
    };

    const handleNextQuestion = () => {
        if (currentQuestionIndex < questions.length - 1) {
            setCurrentQuestionIndex(prevIndex => prevIndex + 1);
        }
    };

    const handlePreviousQuestion = () => {
        if (currentQuestionIndex > 0) {
            setCurrentQuestionIndex(prevIndex => prevIndex - 1);
        }
    };
    const evaluateAnswers = async () => {
        try {
            // Iterate over userAnswers state and create QuizAttemptAnswer for each answer
            const answerPromises = Object.entries(userAnswers).map(async ([questionIndex, optionId]) => {
                const question = quiz_questions[questions.length - questionIndex - 1];
                const response = await axios.post(`/api/quiz-attempts/storeAnswer`, {
                    quiz_attempt_id: attemptId,
                    quiz_question_id: question.id,
                    question_option_id: optionId
                });
                console.log(response.data);
                return response.data;
            });

            // Wait for all QuizAttemptAnswer creations to complete
            const createdAnswers = await Promise.all(answerPromises);
            try {
                // Evaluate the quiz attempt
                console.log(content);
                const response = await axios.get(`/content/${content}/quiz/${quiz.id}/complete/${attemptId}`, {
                    params: {
                        attemptId: attemptId,
                        createdAnswers: createdAnswers
                    }
                });

            } catch (error) {
                console.error('Error evaluating answers:', error);
            }
        } catch (error) {
            console.error('Error creating QuizAttemptAnswers:', error);
        }
    };

    if (maxAttemptReached) {
        return <AuthenticatedLayout
            user={auth.user}
            header={<h1 className="font-semibold text-xl text-gray-800 leading-tight">{name}</h1>}
            page_description={<h1 className="font-semibold text-xs text-gray-800 leading-tight">You must
                score {pass_marks} / {total_marks} to pass.</h1>}
        >
            <Head title={name}/>
            <div className="py-6">
                <div className="mx-auto sm:px-6 lg:px-8" style={{width: '70%'}}>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="px-6 py-4 " style={{width: '100%'}}>
                            <h1>You have reached the maximum number of attempts for this quiz.</h1>
                            Please contact your supervisor.
                        </div>
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    ;
    }


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h1 className="font-semibold text-xl text-gray-800 leading-tight">{name}</h1>}
            page_description={<h1 className="font-semibold text-xs text-gray-800 leading-tight">You must score {pass_marks} / {total_marks} to pass</h1>}
        >
            <Head title={name} />
            <div className="py-6">
                <div className="mx-auto sm:px-6 lg:px-8" style={{ width: '70%' }}>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="px-6 py-4" style={{ width: '100%' }}>
                            <button disabled={currentQuestionIndex === 0} onClick={handlePreviousQuestion}>
                                Previous
                            </button>
                            <h2>Question {currentQuestionIndex + 1}:</h2>
                            <div className="py-4">{currentQuestion.name}?</div>
                            <ul>
                                {currentQuestion.question_options.map(option => (
                                    <li className="py-4 px-6" key={option.id} onClick={() => handleAnswerSelection(option.id)}>
                                        <div className={`px-2 py-2 cursor-pointer ${userAnswers[currentQuestionIndex] === option.id ? 'bg-blue-200' : 'hover:bg-gray-200'}`}>
                                            {option.name}
                                        </div>
                                    </li>
                                ))}
                            </ul>
                            <div className="flex justify-center">
                                {currentQuestionIndex !== questions.length - 1 ? (
                                    <button
                                        className={`rounded-full px-1 text-white ${!userAnswers[currentQuestionIndex] ? 'bg-gray-400' : 'bg-navy-blue'}`}
                                        disabled={!userAnswers[currentQuestionIndex]}
                                        onClick={handleNextQuestion}
                                    >
                                        Next
                                    </button>
                                ) : (
                                    <a
                                        href={attemptId ? route('showQuizResult', {
                                            quiz: quiz, learningContent: content,  attemptId: attemptId,
                                        }) : '#'}
                                        className={`rounded-full px-1 text-white ${(!attemptId || !userAnswers[currentQuestionIndex]) ? 'bg-gray-400' : 'bg-navy-blue'}`}
                                        disabled={!attemptId || !userAnswers[currentQuestionIndex]}
                                        onClick={evaluateAnswers}
                                    >
                                        Results
                                    </a>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
