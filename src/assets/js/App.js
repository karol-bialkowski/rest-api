import React from 'react';
import ListingForm from "./components/ListingForm";
import Loading from "./components/Loading";
import ProductListing from "./components/ProductListing";
import InsertForm from "./components/InsertForm";

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

    insert = () => {
        fetch('/products', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                title: this.state.productTitle,
                price: this.state.productPrice,
            })
        })
            .then((res) => {
                return res.json()
            })
            .then((json) => {

                if (json.message != '') {
                    alert(json.message);
                    this.setState({
                        loading: false
                    })
                }

                this.setState({
                    response: json.payload,
                    loading: false
                })
            })
            .catch(function (error) {
                alert('An error occured! Show console log for details.');
                this.setState({
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
            this.insert();
        }

    }

    changeEndpoint = (event) => {
        this.setState({
            endpoint: event.target.value,
            response: null
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
                <ListingForm
                    pageNumber={this.state.pageNumber}
                    changePageNumber={this.changePageNumber}
                />
            )
        }

        if (this.state.endpoint === 'insert') {
            return (
                <InsertForm
                    changeProductTitle={this.changeProductTitle}
                    changeProductPrice={this.changeProductPrice}
                    productTitle={this.state.productTitle}
                    productPrice={this.state.productPrice}
                />
            )
        }

    }

    parsedResponse = () => {

        if (this.state.loading) {
            return (
                <Loading loading={this.state.loading}/>
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
                    {this.state.response.map((product) => <ProductListing product={product}/>)}
                </ul>
            )
        }

        if (this.state.endpoint === 'insert') {
            return (
                <div>Added product has uuid: <strong>{this.state.response.uuid}</strong></div>
            )
        }
    }


    render() {
        return <div>

            {this.selectEndpoint()}
            {this.displayCorrectForm()}

            <button
                type="button"
                onClick={this.sendRequest}
                className="btn btn-primary"
                disabled={this.state.loading}
            >
                Go >>
            </button>

            <br/><br/>
            <div id="response">{this.parsedResponse()}</div>

        </div>;
    }
}

export default Form;