
import { combineReducers } from 'redux'
import authReducer from './authReducer'
import changeState from './changeState'

const rootReducer = combineReducers({
    ui: changeState, 
    auth: authReducer, 
  })
  
  export default rootReducer