
  const initialState = {
    accessToken: localStorage.getItem('accessToken') || null,
    isAuthenticated: !!localStorage.getItem('accessToken'), // Token varsa true
  }

  const authReducer = (state = initialState, action) => {
    switch (action.type) {
      case 'LOGIN_SUCCESS':
        return {
          ...state,
          accessToken: action.payload.accessToken,
          isAuthenticated: true,
        }
      case 'LOGOUT':
        return {
          ...state,
          accessToken: null,
          isAuthenticated: false,
        }
      default:
        return state
    }
  }
  
  export default authReducer