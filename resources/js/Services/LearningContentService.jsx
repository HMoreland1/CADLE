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
                const responseData = await response.json();
                console.log("Response Data: ", responseData); // Log response data to console
                return responseData;
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
    },


    getAssignedContentCompletionStatus: async (userId) => {
        let endpoint = `api/learning-content/user/${userId}/status`;

       return await fetch(endpoint);


    },

    getPathwayContent: async (pathway) => {
        try {
            const response = await axios.get(`/api/learning-content/pathway/${pathway.id}`);
            return response.data;
        } catch (error) {
            console.error('Error fetching pathway content:', error);
            throw error;
        }
    }

};

export default LearningContentService;
