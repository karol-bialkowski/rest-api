import React from 'react';

const ProductListing = (props) => {
    return <li>{props.product.title}, <strong>{props.product.price.format.usd}</strong></li>
}
export default ProductListing;