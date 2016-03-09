import React from 'react';
import ReactDOM from 'react-dom';

import WalletList from 'components/WalletList';
import jQuery from 'jquery';

import 'style/generic';

var walletList = document.getElementById('js-wallet-list')

ReactDOM.render(
    <WalletList url="/api/wallets"/>,
    walletList
);
