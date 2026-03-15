//
//  AppDelegate.h
//  BikeTracker
//
//  Created by Peter Gerhat on 10/24/14.
//  Copyright (c) 2014 Peter Gerhat. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <CoreLocation/CoreLocation.h>

//@interface AppDelegate : UIResponder <UIApplicationDelegate>

//Specify this app delegate complies with the location manager delegate
@interface CFAAppDelegate : UIResponder <UIApplicationDelegate, CLLocationManagerDelegate>

@property (strong, nonatomic) UIWindow *window;

//Add a location manager property to this app delegate
@property (strong, nonatomic) CLLocationManager *locationManager;

@end

