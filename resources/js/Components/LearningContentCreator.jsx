// resources/js/components/PopupWindow.jsx

import React, { useRef, useEffect } from 'react';
import { Dialog, Transition } from '@headlessui/react';
import Vvveb from "vvvebjs";

const PopupWindow = ({ isOpen, onClose, children }) => {
    const editorRef = useRef(null);

    useEffect(() => {
        if (isOpen) {
            initializeVvvebEditor();
        }
    }, [isOpen]);

    const initializeVvvebEditor = () => {
        const VvvebBuilder = window.Vvveb.Builder;
        const editor = VvvebBuilder.init(editorRef.current);
        // Additional initialization options or customizations can be added here
    };

    // Function to save content
    function saveContent() {
        const htmlContent = editor.html(); // Get HTML content from VvvebJs editor
        document.getElementById('learning_content_content').value = htmlContent; // Update textarea with HTML content
        closePopup(); // Close the popup

        // You can optionally submit the form or perform other actions here
        function Test() {
            console.log("test");
        }
    }

    return (
        <Transition show={isOpen} as={React.Fragment}>
            <Dialog
                as="div"
                className="fixed inset-0 z-50 overflow-y-auto"
                onClose={onClose}
            >
                <div className="flex items-center justify-center min-h-screen">
                    <Transition.Child
                        as={React.Fragment}
                        enter="ease-out duration-300"
                        enterFrom="opacity-0"
                        enterTo="opacity-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        <Dialog.Overlay className="fixed inset-0 bg-black opacity-30" />
                    </Transition.Child>

                    <Transition.Child
                        as={React.Fragment}
                        enter="ease-out duration-300"
                        enterFrom="opacity-0 scale-95"
                        enterTo="opacity-100 scale-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100 scale-100"
                        leaveTo="opacity-0 scale-95"
                    >
                        <div className="bg-white rounded-lg p-6 w-4/5">
                            {/* VvvebJs Editor */}
                            <div ref={editorRef} style={{ height: '500px' }}></div>
                            {/* End VvvebJs Editor */}

                            {/* Other popup content */}
                            {children}
                        </div>
                    </Transition.Child>
                </div>
            </Dialog>
        </Transition>
    );

};

export default PopupWindow;
