/*
 * Copyright 2012 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package com.google.android.gcm.demo.server;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 * Servlet that registers a device, whose registration id is identified by
 * {@link #PARAMETER_REG_ID}.
 *
 * <p>
 * The client app should call this servlet everytime it receives a
 * {@code com.google.android.c2dm.intent.REGISTRATION C2DM} intent without an
 * error or {@code unregistered} extra.
 */
@SuppressWarnings("serial")
public class RegisterServlet extends BaseServlet {

	
  private static final String PARAMETER_REG_ID = "regId";
  private static final String PARAMETER_USER_ID = "user_id";

  //http://localhost:8080/active-info-backend/register?regId=APA91bEgtEPLnBTLqq-_AcjkL__d1hdrBsMOskWz1N4h4xo5acQJCp4bs_NxiFkQcM6zeJyudJIW-0bZedpv89C50j89bWI0FowxdFb21ngZJfGfQhu4oh7bpY-DRR_lk_Sw77n7yhHd&user_id=1
  
  @Override
  protected void doPost(HttpServletRequest req, HttpServletResponse resp)
      throws ServletException {
    String regId = getParameter(req, PARAMETER_REG_ID);
    String userId = getParameter(req, PARAMETER_USER_ID);
    Datastore.register(regId, userId);
    setSuccess(resp);
  }

}
