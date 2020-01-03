import React from 'react';

class InsertForm extends React.Component {

    render() {

        return (
            <div>
                <label>Title</label>
                <input type="text" onChange={this.props.changeProductTitle} maxLength="100"
                       value={this.props.productTitle} className="form-control"/>
                <small className="form-text text-muted">Typed: {this.props.productTitle}</small> <br/>

                <label>Price</label>
                <input type="number" onChange={this.props.changeProductPrice} value={this.props.productPrice}
                       maxLength="5" className="form-control"/>
                <small className="form-text text-muted">Allowed only cents, instead $2.99 fill 299. </small> <br/><br/>
            </div>
        );
    }
}

export default InsertForm;