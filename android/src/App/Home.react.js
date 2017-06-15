import React, { Component, PropTypes } from 'react';
import { 
StyleSheet, 
ToastAndroid,
ScrollView,
Platform,
Animated,
Easing,
View,
Text,
Image
} from 'react-native';

import routes from '../routes';

import Container from '../Container';

// components
import {
    ActionButton,
    Avatar,
    ListItem,
    Toolbar,
    BottomNavigation,
    Icon,
	Card
} from 'react-native-material-ui/src';

const UP = 1;
const DOWN = -1;
const styles = StyleSheet.create({
    textContainer: {
        paddingBottom: 16,
    },
});
const t_styles = StyleSheet.create({
  titleText: {
    fontSize: 20,
    fontWeight: 'bold',
  }
});

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
            active: 'home',
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
                leftElement={{
					actions: ['menu'],
					menu: { labels: ['Item 1', 'Item 2'] },
                 }}
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
                <View>
				  <Card>
					<Image source={require('../img/nature-600-337.jpg')} />
					<View style={styles.textContainer}>
                        <Text style={t_styles.titleText}>
							故事一则：
                            同事们一起去吃饭，有个同事来晚了：服务员，看见我们公司的同事去哪里了吗？
							哦，他们上二楼了。“二楼几层呀？”“二楼....
                        </Text>
                    </View>
				  </Card>
				</View>
                <BottomNavigation
                    active={this.state.active}
                    hidden={this.state.bottomHidden}
                    style={{ container: { position: 'absolute', bottom: 0, left: 0, right: 0,paddingHorizontal: 16, alignItems: 'center', justifyContent: 'center' } }}
                >
				   <BottomNavigation.Action
                        key="home"
                        icon={<Icon name="home" />}
                        label="主页"
                        onPress={() => this.props.navigator.resetTo(routes.home)}
						style={{ container: { left:15} }}
                    />
                    <BottomNavigation.Action
                        key="games"
                        icon={<Icon name="games" />}
                        label="小游戏"
                        onPress={() => this.props.navigator.resetTo(routes.gamePage)}
                    />
                    <BottomNavigation.Action
                        key="video-call"
                        icon={<Icon name="video-call" />}
                        label="小视频"
                        onPress={() => this.setState({ active: 'picture-in-picture' })}
                    />
                    <BottomNavigation.Action
                        key="picture-in-picture"
                        icon={<Icon name="picture-in-picture" />}
                        label="小图片"
                        onPress={() => this.setState({ active: 'picture-in-picture' })}
                    />
					<BottomNavigation.Action
                        key="book"
                        icon={<Icon name="book" />}
                        label="小小说"
                        onPress={() => this.props.navigator.resetTo(routes.bookPage)}
						style={{ container: { right:15} }}
                    />
                </BottomNavigation>
            </Container>


        );
    }
}

Home.propTypes = propTypes;

export default Home;
