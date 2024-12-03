import { SET_SIDEBAR_SHOW,SET_SIDEBAR_UNFOLDABLE } from '../actions/uiActions';

const initialState = {
    sidebarShow: true,
    theme: 'light',
    sidebarUnfoldable: false,
  }
  
  const changeState = (state = initialState, action) => {
    switch (action.type) {
      case SET_SIDEBAR_SHOW:
        return {
          ...state,
          sidebarShow: action.sidebarShow,
        };
        case SET_SIDEBAR_UNFOLDABLE:
  return {
    ...state,
    sidebarUnfoldable: action.sidebarUnfoldable,
  };
      default:
        return state;
    }
  };
  
  export default changeState