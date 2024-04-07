import JSZip from 'jszip';

const ScormUtils = {
    generateHTMLContent: () => {
        // Retrieve the HTML content of the div with classname 'canvas'
        const canvasContent = document.querySelector('.canvas').innerHTML;

        // Construct the full HTML content with Bootstrap styles
        return `
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Canvas</title>
                <!-- Include Bootstrap CSS -->
                <link href="bootstrap.min.css" rel="stylesheet">
                <!-- Include custom CSS styles here if needed -->
            </head>
            <body>
                <div class="canvas-container">
                    ${canvasContent}
                </div>

                <!-- Include Bootstrap JS (optional) -->
                <script src="bootstrap.bundle.min.js"></script>
                <!-- Include custom JS scripts here if needed -->
            </body>
            </html>
        `;
    },

    generateSCORMManifest: (htmlContent) => {
        // Ensure htmlContent is an array
        htmlContent = Array.isArray(htmlContent) ? htmlContent : [htmlContent];

        // Generate resources section of the manifest based on the HTML content
        const resourcesXML = htmlContent.map((content, index) => `
            <resource identifier="resource_${index + 1}" type="webcontent" adlcp:scormType="sco" href="content${index + 1}.html">
                <file href="content${index + 1}.html"/>
            </resource>`).join('\n');

        // Construct the full manifest XML
        return `<?xml version="1.0" encoding="UTF-8"?>
            <manifest identifier="your_package_identifier" version="1.0" xmlns="http://www.imsproject.org/xsd/imscp_rootv1p1p2" xmlns:adlcp="http://www.adlnet.org/xsd/adlcp_rootv1p2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.imsproject.org/xsd/imscp_rootv1p1p2 imscp_rootv1p1p2.xsd">
                <metadata>
                    <schema>ADL SCORM</schema>
                    <schemaversion>2004 4th Edition</schemaversion>
                </metadata>
                <organizations default="CADLE">
                    <organization identifier="CADLE">
                        <title>CADLE</title>
                        ${htmlContent.map((_, index) => `<item identifier="item_${index + 1}" identifierref="resource_${index + 1}">
                            <title>Content Item ${index + 1}</title>
                        </item>`).join('\n')}
                    </organization>
                </organizations>
                <resources>
                    ${resourcesXML}
                </resources>
            </manifest>`;
    },

    packageSCORMContent: (htmlContent, scormManifest) => {
        // Package HTML content and SCORM manifest into a ZIP file
        const zip = new JSZip();

        // Add Bootstrap CSS file
        zip.file('bootstrap.min.css', '/* Bootstrap CSS content here */');

        // Add Bootstrap JS file (optional)
        zip.file('bootstrap.bundle.min.js', '/* Bootstrap JS content here */');

        // Convert HTML content to string
        const fullHtmlContent = Array.isArray(htmlContent) ? htmlContent.join('\n') : htmlContent;

        // Add SCORM manifest
        zip.file('imsmanifest.xml', scormManifest);

        // Add the HTML content to the ZIP file
        zip.file('content.html', fullHtmlContent);

        return zip;
    },

    exportSCORMPackage: (scormPackage) => {
        // Export the SCORM package as a downloadable ZIP file
        scormPackage.generateAsync({ type: 'blob' })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'scorm_package.zip';
                a.click();
            })
            .catch(error => console.error('Error exporting SCORM package:', error));
    }
};

export default ScormUtils;
