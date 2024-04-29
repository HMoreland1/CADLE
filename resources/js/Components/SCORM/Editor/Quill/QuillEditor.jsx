import { useState, useEffect, useRef } from 'react';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const QuillEditor = ({ column, value, onChange }) => {
    const quillContainerRef = useRef(null);
    const quillRef = useRef(null);
    const [editorContent, setEditorContent] = useState(value); // Local state to store editor content

    useEffect(() => {
        // Initialize Quill editor after component is mounted
        if (quillContainerRef.current) {
            quillRef.current = new Quill(quillContainerRef.current, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }], // Size option added here
                        ['clean']
                    ]

                }
            });

            // Set initial value
            console.log("value: ", value)
            if (value) {
                quillRef.current.root.innerHTML = value;
            }
            // Listen for text-change events and update local state
            quillRef.current.on('text-change', () => {
                const updatedValue = quillRef.current.root.innerHTML;
                setEditorContent(updatedValue);
            });
        }

        // Cleanup function
        return () => {
            if (quillRef.current) {
                quillRef.current.off('text-change');
                quillRef.current = null;
            }
        };
    }, []); // No dependencies, only run once on mount

    // Update editor content when value prop changes
    useEffect(() => {
        // Update editor content only if the value differs from the current editor content

        quillRef.current.root.innerHTML = value;
        setEditorContent(value);
    }, [value]); // Only run when the value prop changes

    // Listen for editor content changes and propagate them to the parent component
    useEffect(() => {
        const handleChange = () => {
            const updatedValue = quillRef.current.root.innerHTML;

            onChange(updatedValue);
            setEditorContent(updatedValue);

        };

        // Listen for text-change events
        if (quillRef.current) {
            quillRef.current.on('text-change', handleChange);
        }

        // Cleanup function
        return () => {
            if (quillRef.current) {
                quillRef.current.off('text-change', handleChange);
            }
        };
    }, [onChange]); // Only run when the onChange prop changes

    return <div className="quill-editor" ref={quillContainerRef} />;
};

export default QuillEditor;
