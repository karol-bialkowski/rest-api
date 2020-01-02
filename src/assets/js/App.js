import React from 'react';

class Form extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            endpoint: 'listing',
            pageNumber: 1,
            productTitle: '',
            productPrice: 0,
            response: null,
            loading: false
        };
    }

    listing = () => {
        fetch("/products?page=" + this.state.pageNumber)
            .then(res => res.json())
            .then((json) => {
                this.setState({
                    response: json.payload.products,
                    loading: false
                })
            });
    }

    sendRequest = () => {

        this.setState({
            loading: true
        });

        if (this.state.endpoint === 'listing') {
            this.listing();
        }

        if (this.state.endpoint === 'insert') {
            console.log(
                'insert',
                this.state.productTitle,
                this.state.productPrice
            );
        }

    }

    changeEndpoint = (event) => {
        this.setState({
            endpoint: event.target.value
        })
    }

    changePageNumber = (event) => {
        this.setState({
            pageNumber: event.target.value
        })
    }

    changeProductTitle = (event) => {
        this.setState({
            productTitle: event.target.value
        })
    }

    changeProductPrice = (event) => {
        this.setState({
            productPrice: event.target.value
        })
    }

    selectEndpoint = () => {
        return (
            <div>
                <select onChange={this.changeEndpoint} value={this.state.endpoint} className="form-control">
                    <option value="listing">Listing products</option>
                    <option value="insert">Insert</option>
                </select> <br/>
            </div>
        )
    }

    displayCorrectForm = () => {

        if (this.state.endpoint === 'listing') {
            return (
                <div>
                    <div className="form-group">
                        <label htmlFor="page">Select page number</label>
                        <input
                            type="number"
                            min="1"
                            className="form-control"
                            id="page" value={this.state.pageNumber}
                            onChange={this.changePageNumber}/>
                    </div>
                </div>

            )
        }

        if (this.state.endpoint === 'insert') {

            return (
                <div>
                    <label>Title</label>
                    <input type="text" onChange={this.changeProductTitle} maxLength="100" className="form-control"/>
                    <small class="form-text text-muted">Typed: {this.state.productTitle}</small> <br/>

                    <label>Price</label>
                    <input type="number" onChange={this.changeProductPrice} maxLength="5" className="form-control"/>
                    <small class="form-text text-muted">Allowed only cents, instead $2.99 fill 299. </small> <br/><br/>
                </div>
            )

        }

    }

    parsedResponse = () => {

        if (this.state.loading) {
            return (
                <div>
                    Loading...
                </div>
            )
        }

        if (this.state.response === null) {
            return (
                <div>--</div>
            )
        }

        if (this.state.endpoint === 'listing') {
            return (
                <ul>
                    {this.state.response.map((product) =>
                        <li>{product.title}, <strong>{product.price.format.usd}</strong></li>)}
                </ul>
            )
        }
    }


    render() {
        return <div>

            {this.selectEndpoint()}
            {this.displayCorrectForm()}

            <button type="button" onClick={this.sendRequest} class="btn btn-primary">Go >></button>

            <br/><br/>
            <div id="response">{this.parsedResponse()}</div>

        </div>;
    }
}

export default Form;