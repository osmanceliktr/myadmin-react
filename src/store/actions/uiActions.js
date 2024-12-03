export const SET_SIDEBAR_SHOW = 'SET_SIDEBAR_SHOW';
export const SET_SIDEBAR_UNFOLDABLE = 'SET_SIDEBAR_UNFOLDABLE';

export const setSidebarShow = (visible) => ({
  type: SET_SIDEBAR_SHOW,
  sidebarShow: visible,
});


export const setSidebarUnfoldable = (unfoldable) => ({
  type: SET_SIDEBAR_UNFOLDABLE,
  sidebarUnfoldable: unfoldable,
});