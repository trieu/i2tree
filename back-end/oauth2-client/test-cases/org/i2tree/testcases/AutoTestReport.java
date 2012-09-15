package org.i2tree.testcases;

import java.io.FileOutputStream;
import java.io.PrintStream;

import junit.framework.TestSuite;

import com.sun.xml.internal.ws.api.pipe.Engine;

public class AutoTestReport {
	public static void main(String[] args) {

		PrintStream oldoutps = System.out; // get the current output stream

		try {

			FileOutputStream outfos = new FileOutputStream("Test Output.htm"); // create
																				// //new
																				// output
																				// stream

			PrintStream newoutps = new PrintStream(outfos); // create new output
															// //stream

			System.setOut(newoutps); // set the output stream

			System.out.println("Output of Junit Testing");
			System.out.println("");
			System.out.println("");
			junit.textui.TestRunner.run(suite());
			System.out.println("test finished");
			System.out.println("");
			System.setOut(oldoutps); // for resetting the output stream
		} catch (Exception e) {

			System.out.println("some error");

		}

	}

	// suite method

	private static TestSuite suite() {

		TestSuite suite = new TestSuite("Test for Engine. HelloWorldTest.java");

		// $JUnit-BEGIN$

		suite.addTestSuite(CaseLogin.class);

		// $JUnit-END$

		return suite;

	}
}
