import { AppRegistry } from 'react-native';
import React, { Component } from 'react';

import App from './src/App/App.react';


export default class Root extends Component {
        render() {
            return (
                <App />
            );
        }
}

 AppRegistry.registerComponent('ki', () => Root);