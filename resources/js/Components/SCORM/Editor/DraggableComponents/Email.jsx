import './Email.css';
import parse from "html-react-parser"; // Import the CSS file
const Email = ({ sender, subject, body, date }) => {
    return (
        <div className="email">
            <div className="email-header">
                <div className="sender">{sender[0].value}</div>
                <div className="date">{date[0].value}</div>
            </div>
            <div className="email-body">
                <div className="subject">{subject[0].value}</div>
                <div className="content">{parse(body[0].value)}</div>
            </div>
        </div>
    );
};

export default Email;
