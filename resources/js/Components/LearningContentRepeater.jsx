import React, { useState, useEffect, useLayoutEffect } from 'react';
import LearningContentService from '@/Services/LearningContentService.jsx';
import '/resources/css/LearningContentRepeater.css';
import defaultImage from '/resources/imgs/LearningContentThumbnails/default.jpg';

const LearningContentRepeater = ({ userId, showFilterByDefault, fillWindow, assignedContentIds}) => {
    // State variables initialization
    const [learningContent, setLearningContent] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerRow, setItemsPerRow] = useState(1);
    const [rowsPerPage, setRowsPerPage] = useState(1);
    const [showFilter, setShowFilter] = useState(showFilterByDefault);
    const [selectedCategory, setSelectedCategory] = useState(null);
    const [searchQuery, setSearchQuery] = useState('');


    // Fetch learning content and set states when component mounts or userId changes
    useEffect(() => {
        const fetchLearningContent = async () => {
            try {
                let content;
                if (userId) {
                    content = await LearningContentService.getAssignedContent(userId);
                    if (!content || content.length === 0) {
                        setError("Your training is currently up to date.");
                    }
                }
                else if(assignedContentIds != null) {
                    content = await LearningContentService.getPathwayContent(assignedContentIds);
                }else
                {
                    content = await LearningContentService.getAssignedContent();
                }
                setLearningContent(content);
            } catch (error) {
                setError(error.message || 'Error fetching learning content');
            } finally {

                setIsLoading(true);
                // Adjust itemsPerRow if there are fewer items than itemsPerRow suggests
            }

        }

        fetchLearningContent()
    }, [userId]);

    useEffect(() => {
        // This function will be executed whenever isLoading changes
        const handleStateChange = async () => {
            // Do something when isLoading changes
            console.log("isLoading changed:", isLoading);
            // Call any other functions or logic you want to execute
            if (isLoading) {
                console.log("Learning Content Length: ", learningContent.length);
                setItemsPerRow(Math.min(itemsPerRow, learningContent.length));
                console.log("Row: ",itemsPerRow);
            }
        }

        // Call the function when the component mounts, to handle initial state
        handleStateChange();

        // Set up the effect to run the function whenever isLoading changes
        return () => {
            // Clean up any resources or subscriptions if necessary
        };
    }, [isLoading]);

    // Calculate layout based on window size
    useLayoutEffect(() => {
        function calculateLayout() {
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            const cardWidth = 250;
            const cardHeight = 300;

            const itemsPerRow = Math.floor(0.8 * windowWidth / cardWidth);
            const rowsPerPage = Math.floor(0.9 * windowHeight / cardHeight);

            console.log("isLoading Calc:", isLoading);
            if(isLoading){
                setItemsPerRow(Math.min(itemsPerRow, learningContent.length));
            }
            else{
                setItemsPerRow(itemsPerRow);
            }


            setRowsPerPage(fillWindow ? rowsPerPage : 1);


        }

        calculateLayout();

        function handleResize() {
            calculateLayout();

        }

        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, [fillWindow]);

    // Filter learning content based on selected category
    const filteredContent = selectedCategory
        ? learningContent.filter(content => content.content_category === selectedCategory)
        : learningContent;

    // Filter learning content based on search query
    const searchedContent = searchQuery.length === 0
        ? filteredContent
        : filteredContent.filter(content => content.title.toLowerCase().includes(searchQuery.toLowerCase()));

    // Calculate total pages for pagination
    const totalPages = Math.ceil(searchedContent.length / (itemsPerRow * rowsPerPage));

    // Function to navigate to previous page
    const prevPage = () => {
        setCurrentPage(prevPage => (prevPage === 1 ? totalPages : prevPage - 1));
    };

    // Function to navigate to next page
    const nextPage = () => {
        setCurrentPage(prevPage => (prevPage === totalPages ? 1 : prevPage + 1));
    };

    // Render loading indicator while fetching data
    if (!isLoading) {
        return <div>Loading...</div>;
    }

    // Render error message if fetching data fails
    if (error) {
        return <div>{error}</div>;
    }

    // Render error message if learning content is not available
    if (!Array.isArray(searchedContent)) {
        return <div>Error: Learning content is not available</div>;
    }

    // Calculate indices for current page
    const startIndex = (currentPage - 1) * itemsPerRow * rowsPerPage;
    const endIndex = Math.min(startIndex + (itemsPerRow * rowsPerPage), searchedContent.length);
    const currentItems = searchedContent.slice(startIndex, endIndex);

    // Render the component
    return (
        <div>
            {/* Render filter dropdown and search bar if showFilterByDefault is true */}
            {showFilterByDefault && (
                <div style={{marginBottom: '20px', display: 'flex', justifyContent: 'flex-start'}}>
                    {showFilter && (
                        <>
                            {/* Filter dropdown */}
                            <select
                                value={selectedCategory || ''}
                                onChange={(e) => setSelectedCategory(e.target.value || null)}
                                style={{marginLeft: '10px', borderRadius: '5px'}}
                            >
                                <option value="">All</option>
                                <option value="category1">Category 1</option>
                                <option value="category2">Category 2</option>
                            </select>
                        </>
                    )}
                    {/* Search bar */}
                    <input
                        type="text"
                        placeholder="Search..."
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        style={{marginLeft: '10px', borderRadius: '5px', padding: '5px'}}
                    />
                </div>
            )}

            {/* Render learning content grid */}
            <div className="container" style={{
                display: 'flex',
                justifyContent: 'center',
                minWidth: '300px',
                maxWidth: '100%',
                overflowX: 'auto'
            }}>
                <div className="p-3 learning-content-container items-center flex" style={{
                    display: 'grid',
                    gridTemplateColumns: `repeat(${itemsPerRow}, 1fr)`,
                    justifyContent: 'center',
                    gap: '10px'
                }}>
                    {/* Iterate over current items and render content tiles */}
                    {currentItems.map((content, index) => (
                        <a key={index} href="#" className="tile-link">
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
                                <div className="tooltip">{content.description}</div>
                            </div>
                        </a>
                    ))}
                    {/* Render message if no matching results */}
                    {searchedContent.length === 0 && (
                        <div>No learning content matches the selected filters.</div>
                    )}
                    {/* Render pagination buttons */}
                    {currentItems.length > 0 && (
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

        </div>

    );
};

export default LearningContentRepeater;
