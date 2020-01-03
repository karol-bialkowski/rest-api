import React from 'react';

class ListingForm extends React.Component {

    render() {
        return (
            <div>
                <div className="form-group">
                    <label htmlFor="page">Select page number:</label>
                    <input
                        type="number"
                        min="1"
                        className="form-control"
                        id="page"
                        value={this.props.pageNumber}
                        onChange={this.props.changePageNumber}/>
                </div>
            </div>
        );
    }
}

export default ListingForm;