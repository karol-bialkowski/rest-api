import React from 'react';

class Loading extends React.Component {

    render() {

        if (this.props.loading) {
            return (
                <div>
                    <div className="lds-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            );
        }
    }
}

export default Loading;