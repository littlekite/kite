import React, { Component, PropTypes } from 'react';
import { ToastAndroid, ScrollView, Platform, Animated, Easing } from 'react-native';

import routes from '../routes';

import Container from '../Container';
// components
import {
    ActionButton,
    Avatar,
    ListItem,
    Toolbar,
    BottomNavigation,
    Icon
} from 'react-native-material-ui/src';

const UP = 1;
const DOWN = -1;

const propTypes = {
    navigator: PropTypes.object.isRequired,
    route: PropTypes.object.isRequired,
};

class Home extends Component {
    constructor(props) {
        super(props);

        this.offset = 0;
        this.scrollDirection = 0;

        this.state = {
            selected: [],
            searchText: '',
            toolbarHidden: false,
            active: 'people',
            moveAnimated: new Animated.Value(0),
        };
    }
    onAvatarPressed = (value) => {
        const { selected } = this.state;

        const index = selected.indexOf(value);

        if (index >= 0) {
            // remove item
            selected.splice(index, 1);
        } else {
            // add item
            selected.push(value);
        }

        this.setState({ selected });
    }
    onScroll = (ev) => {
        const currentOffset = ev.nativeEvent.contentOffset.y;

        const sub = this.offset - currentOffset;

        // don't care about very small moves
        if (sub > -2 && sub < 2) {
            return;
        }

        this.offset = ev.nativeEvent.contentOffset.y;

        const currentDirection = sub > 0 ? UP : DOWN;

        if (this.scrollDirection !== currentDirection) {
            this.scrollDirection = currentDirection;

            this.setState({
                bottomHidden: currentDirection === DOWN,
            });
        }
    }
    show = () => {
        Animated.timing(this.state.moveAnimated, {
            toValue: 0,
            duration: 225,
            easing: Easing.bezier(0.0, 0.0, 0.2, 1),
            useNativeDriver: Platform.OS === 'android',
        }).start();
    }
    hide = () => {
        Animated.timing(this.state.moveAnimated, {
            toValue: 56, // because the bottom navigation bar has height set to 56
            duration: 195,
            easing: Easing.bezier(0.4, 0.0, 0.6, 1),
            useNativeDriver: Platform.OS === 'android',
        }).start();
    }
    renderToolbar = () => {
        if (this.state.selected.length > 0) {
            return (
                <Toolbar
                    key="toolbar"
                    leftElement="clear"
                    onLeftElementPress={() => this.setState({ selected: [] })}
                    centerElement={this.state.selected.length.toString()}
                    rightElement={['delete']}
                    style={{
                        container: { backgroundColor: 'white' },
                        titleText: { color: 'rgba(0,0,0,.87)' },
                        leftElement: { color: 'rgba(0,0,0,.54)' },
                        rightElement: { color: 'rgba(0,0,0,.54)' },
                    }}
                />
            );
        }
        return (
            <Toolbar
                key="toolbar"
                leftElement="menu"
                onLeftElementPress={() => this.props.navigator.pop()}
                //centerElement={this.props.route.title}
				centerElement="风筝互娱"
                searchable={{
                    autoFocus: true,
                    placeholder: 'Search',
                    onChangeText: value => this.setState({ searchText: value }),
                    onSearchClosed: () => this.setState({ searchText: '' }),
                }}
            />
        );
    }
    renderItem = (title, route, pic) => {
        const searchText = this.state.searchText.toLowerCase();

        if (searchText.length > 0 && title.toLowerCase().indexOf(searchText) < 0) {
            return null;
        }

        return (
            <ListItem
                divider
                //leftElement={<Avatar text={title[0]} />}
				leftElement={<Icon name={pic} />}
                onLeftElementPress={() => this.onAvatarPressed(title)}
                centerElement={title}
                onPress={() => this.props.navigator.push(route)}
            />

        );
    }
    render() {
        return (
            <Container>
                {this.renderToolbar()}
                <ScrollView
                    keyboardShouldPersistTaps
                    keyboardDismissMode="interactive"
                    onScroll={this.onScroll}
                >
                    {this.renderItem('极品飞车', routes.actionButton,'airport-shuttle')}
                </ScrollView>
                <BottomNavigation
                    active={this.state.active}
                    hidden={this.state.bottomHidden}
                    style={{ container: { position: 'absolute', bottom: 0, left: 0, right: 0,alignItems: 'center', justifyContent: 'center' } }}
                >
                    <BottomNavigation.Action
                        key="games"
                        icon={<Icon name="games" />}
                        label="小游戏"
                        onPress={() => this.setState({ active: 'games' })}
                    />
                    <BottomNavigation.Action
                        key="video-call"
                        icon="video-call"
                        label="小视频"
                        onPress={() => this.setState({ active: 'video-call' })}
                    />
                    <BottomNavigation.Action
                        key="picture-in-picture"
                        icon="picture-in-picture"
                        label="小图片"
                        onPress={() => this.setState({ active: 'picture-in-picture' })}
                    />
					<BottomNavigation.Action
                        key="book"
                        icon="book"
                        label="小小说"
                        onPress={() => this.setState({ active: 'book' })}
                    />
                </BottomNavigation>
            </Container>


        );
    }
}

Home.propTypes = propTypes;

export default Home;
