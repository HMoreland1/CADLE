import React, { useState, useEffect, useLayoutEffect } from 'react';
import LearningContentService from '@/Services/LearningContentService.jsx';
import '/resources/css/LearningContentRepeater.css'; // Import CSS file for styling
import defaultImage from '/resources/imgs/LearningContentThumbnails/default.jpg'; // Import default image

const LearningContentRepeater = ({ userId, showFilterByDefault, fillWindow }) => {
    const [learningContent, setLearningContent] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage, setItemsPerPage] = useState(1); // Initial value, will be updated later
    const [showFilter, setShowFilter] = useState(showFilterByDefault); // State for filter visibility
    const [selectedCategory, setSelectedCategory] = useState(null); // State for selected category

    useEffect(() => {
        const fetchLearningContent = async () => {
            try {
                let content;
                if (userId) {
                    content = await LearningContentService.getAssignedContent(userId);
                    if (!content || content.length === 0) {
                        setError("Your training is currently up to date.");
                    }
                } else {
                    content = await LearningContentService.getAssignedContent(); // Fetch all content if userId is not provided
                }
                setLearningContent(content);
            } catch (error) {
                setError(error.message || 'Error fetching learning content');
            } finally {
                setIsLoading(false);
            }
        };

        fetchLearningContent();
    }, [userId]);

    // Update the number of items per page when the screen size changes or after initial render
    useLayoutEffect(() => {
        function calculateItemsPerPage() {
            if (fillWindow) {
                const windowHeight = window.innerHeight;
                const windowWidth = window.innerWidth;
                const cardHeight = 200; // Adjust this value to match your card height
                const cardWidth = 150; // Adjust this value to match your card width
                const itemsPerRow = Math.floor(windowWidth * 0.8 / cardWidth);
                const rows = Math.floor(windowHeight * 0.5 / cardHeight);
                const itemsPerPage = itemsPerRow * rows;
                console.log("Items per page:", itemsPerPage); // Log the value of itemsPerPage
                return itemsPerPage; // Calculate items per page based on window height and card height
            } else {
                const windowWidth = window.innerWidth;
                const cardWidth = 150; // Adjust this value to match your card width
                return Math.max(1, Math.floor(windowWidth / cardWidth)); // Fill horizontally regardless of fillWindow setting
            }
        }

        // Calculate items per page after initial render
        setItemsPerPage(calculateItemsPerPage());

        function handleResize() {
            setItemsPerPage(calculateItemsPerPage());
        }

        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, [fillWindow]);

    // Filter content by category
    const filteredContent = selectedCategory
        ? learningContent.filter(content => content.content_category === selectedCategory)
        : learningContent;

    // Pagination logic
    const totalPages = Math.ceil(filteredContent.length / itemsPerPage);


    const prevPage = () => {
        setCurrentPage((prevPage) => (prevPage === 1 ? totalPages : prevPage - 1));
    };

    const nextPage = () => {
        setCurrentPage((prevPage) => (prevPage === totalPages ? 1 : prevPage + 1));
    };

    if (isLoading) {
        return <div>Loading...</div>;
    }

    if (error) {
        return <div>{error}</div>;
    }

    // Check if learningContent is an array before rendering
    if (!Array.isArray(filteredContent)) {
        return <div>Error: Learning content is not available</div>;
    }


    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = filteredContent.slice(indexOfFirstItem, indexOfLastItem);

    return (
        <div>
            <div style={{marginBottom: '20px', display: 'flex', justifyContent: 'flex-start'}}>
                {showFilterByDefault && (
                    <>
                        {showFilter && (
                            <select
                                value={selectedCategory || ''}
                                onChange={(e) => setSelectedCategory(e.target.value || null)}
                                style={{marginLeft: '10px' , borderRadius: '5px'}}
                            >
                                <option value="">All</option>
                                <option value="category1">Category 1</option>
                                <option value="category2">Category 2</option>
                                {/* Add more options as needed */}
                            </select>
                        )}
                    </>
                )}
            </div>

            <div className="learning-content-container items-center flex">
                {currentItems.map((content) => (
                    <a key={content.id} href="#" className="tile-link">
                        <div className="learning-content-tile bg-primary-subtle1">
                            <div className="image-container">
                                <img src={content.image_filename || defaultImage} alt={content.title}/>
                            </div>
                            <div className="banner p-3">
                                <p>test{content.content_type}</p>
                            </div>
                            <div className=" p-3 title-container">
                                <h3 style={{fontWeight: 'bold', marginTop: '10px', marginBottom: '10px'}}>
                                    {content.title}
                                </h3>
                            </div>
                            {/* Tooltip */}
                            <div className="tooltip">{content.description}</div>
                        </div>
                    </a>
                ))}
                {/* Show message if no matching results */}
                {filteredContent.length === 0 && (
                    <div>No learning content matches the selected filters.</div>
                )}
                {/* Pagination */}
                {(learningContent.length > 0) && (
                    <>
                        <button className="pagination-btn prev" onClick={prevPage}>
                            {'<'}
                        </button>
                        <button className="pagination-btn next" onClick={nextPage}>
                            {'>'}
                        </button>
                    </>
                )}
            </div>

        </div>
    );

};

export default LearningContentRepeater;
