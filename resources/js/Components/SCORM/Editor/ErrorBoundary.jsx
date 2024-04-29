// ErrorBoundary.jsx
import { Component } from 'react';

class ErrorBoundary extends Component {
    constructor(props) {
        super(props);
        this.state = { hasError: false };
    }

    componentDidCatch(error, info) {
        this.setState({ hasError: true });
        // You can also log the error to an error reporting service
        console.error(error, info);
    }

    render() {
        if (this.state.hasError) {
            return <h1>Something went wrong.</h1>;
        }

        return (
            <div className=".editor">
                {this.props.children}
            </div>
            )
    }
}

export default ErrorBoundary;
