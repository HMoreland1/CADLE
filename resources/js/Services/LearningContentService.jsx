const LearningContentService = {
    getAssignedContent: async (userId) => {
        try {
            let endpoint;
            if (userId) {
                endpoint = `api/learning-content/user/${userId}`;
            } else {
                endpoint = 'api/learning-content/all';
            }

            const response = await fetch(endpoint);

            if (!response.ok) {
                console.error(`Failed to fetch learning content: ${response.status} - ${response.statusText}`);
            }

            const contentType = response.headers.get('content-type');
            console.log("Content Type: ", contentType);
            if (contentType && contentType.includes('application/json')) {
                // If content type is JSON, parse response as JSON
                return await response.json();
            } else {
                // If content type is not JSON (e.g., HTML), handle HTML response
                console.error('Received non-JSON response from server');
                console.log(response);
                return [];
            }
        } catch (error) {
            console.error(`Failed to fetch learning content: ${error.message}`);
            throw new Error('Failed to fetch learning content');
        }
    }
};

export default LearningContentService;
